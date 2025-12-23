<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InferencedImage;
use App\Models\User;
use App\Notifications\NotifyUserForValidationResultNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LogsController extends Controller
{
    public function index()
    {
        $status = urldecode(request('status'));

        $expert_validation = [
            1 => "Accurate",
            2 => "Less Accurate",
            3 => "Not Accurate"
        ];

        $query  = InferencedImage::join('users as u', 'inferenced_images.user_id', '=', 'u.id')
            ->select([
                'inferenced_images.*',
                'u.brgy'
            ])
            ->orderBy('inferenced_images.created_at', 'desc');

        if (!empty($status)) $query->where('inferenced_images.status', $status);

        if (Auth::user()->role == 3) $query->where('inferenced_images.user_id', Auth::user()->id);

        $data = $query->paginate(15)->withQueryString();

        foreach ($data as $item) {
            $item->encrypted_id = Crypt::encrypt($item->id);

            if ($item->expert_validation == 1) $item->expert_validation_string_format = $expert_validation[$item->expert_validation];
            if ($item->expert_validation == 2) $item->expert_validation_string_format = $expert_validation[$item->expert_validation];
            if ($item->expert_validation == 3) $item->expert_validation_string_format = $expert_validation[$item->expert_validation];
        }

        return view('pages.auth.logs.index', [
            'data' => $data
        ]);
    }

    /**
     * update
     */
    public function update(string $id, Request $request): JsonResponse
    {
        $d_id = Crypt::decrypt(urldecode($id));

        $row = InferencedImage::findOrFail($d_id);

        $update = match ($request->type) {
            1 => $row->update(['status' => 2, 'expert_validation' => $request->type]),
            2 => $row->update(['status' => 3, 'expert_validation' => $request->type]),
            3 => $row->update(['status' => 4, 'expert_validation' => $request->type])
        };

        if (!$update) return response()->json([], 500);

        $user = User::findOrFail($row->user_id);

        $update_type = match ($request->type) {
            1 => "Accurate",
            2 => "Less Accurate",
            3 => "Not Accurate"
        };

        $user->notify(new NotifyUserForValidationResultNotification(json_decode(json_encode([
            'title' => 'Validation Result',
            'description' => "Your Abaca Validation Result is $update_type",
            'log_id' => $d_id
        ]))));

        return response()->json([], 200);
    }

    /**
     * show
     */
    public function show(string $id): View
    {
        $decrypted_id = Crypt::decrypt(urldecode($id));

        $data = InferencedImage::findOrFail($decrypted_id);

        $data->description = $this->getClassDescription($data->system_predicted_class);

        return view('pages.auth.logs.show', [
            'data' => $data
        ]);
    }

    /**
     * get class addition description
     */
    private function getClassDescription(string $class): array
    {
        $return = [];

        switch ($class) {
            case 'SS2':
                $return = [
                    "Name" => "Spindle-/Machine-Stripped S2",
                    'Quality' => "Excellent",
                    'Meaning' => "Machine-stripped version of S2 (\"S‑S2\"), very fine and clean",
                    "Typical Uses" => "Currency paper, premium filters, specialty paper, high-quality cordage",
                    "Description" => "Same characteristics as S2 but processed by spindle/machine. Clean, fine, light-colored; excellent stripping consistency"
                ];
                break;
            case 'S2':
                $return = [
                    "Name" => "",
                    'Quality' => "Excellent",
                    'Meaning' => "\"Streaky Two\" — very fine, clean, light ivory fiber",
                    "Typical Uses" => "Currency paper, tea bags, specialty paper, premium cordage",
                    "Description" => "Fiber size: 0.20–0.50 mm, Ivory white to very light brown/red streaks, Texture: Soft, very fine and Comes from inner/middle leaf sheaths"
                ];
                break;
            case 'SS3':
                $return = [
                    "Name" => "Spindle-/Machine-Stripped S3",
                    'Quality' => "Excellent",
                    'Meaning' => "Machine-stripped version of S3 (\"S‑S3\"), slightly darker excellent grade",
                    "Typical Uses" => "Filters, premium industrial paper, woven products",
                    "Description" => "Same characteristics as S3 but processed by machine and Excellent-quality fiber with more consistent strip"
                ];
                break;
            case 'S3':
                $return = [
                    "Name" => "",
                    'Quality' => "Excellent",
                    'Meaning' => "\"Streaky Three\" — fine but slightly darker than S2",
                    "Typical Uses" => "Filters, fine papers, high-quality weaving",
                    "Description" => "Fiber size: 0.20–0.50 mm, Color: Reddish, purple, or darker brown tones and Comes from outer leaf sheaths"
                ];
                break;
            case 'I':
                $return = [
                    "Name" => "Current Grade",
                    'Quality' => "Good",
                    'Meaning' => "Medium color & fineness",
                    "Typical Uses" => "Rope, industrial paper, geotextiles",
                    "Description" => "Fiber size: 0.51–0.99 mm, Color: Very light to light brown, Texture: Medium soft and Good stripping quality"
                ];
                break;
            case 'G':
                $return = [
                    "Name" => "Soft Seconds",
                    'Quality' => "Good",
                    'Meaning' => "Light brown, medium-soft good fiber",
                    "Typical Uses" => "Rope/twine, fiber composites",
                    "Description" => "Fiber size: 0.51–0.99 mm, Color: Dingy white, light green, dull brown, Same leaf sheath origin as S2 and Good stripping quality"
                ];
                break;
            case 'T':
                $return = [
                    "Name" => "Tow",
                    'Quality' => "Lowest",
                    'Meaning' => "Short, tangled, broken fibers",
                    "Typical Uses" => "Mats, stuffing, pulp filler, coarse brushes",
                    "Description" => "Fiber length: < 60 cm, Made of broken, tip-cut, or tangled residues and Classified as residual grade"
                ];
                break;
            case 'JK':
                $return = [
                    "Name" => "Seconds",
                    'Quality' => "Fair",
                    'Meaning' => "Coarse, yellow-brown fiber",
                    "Typical Uses" => "Sacks, kraft paper, lower-grade ropes",
                    "Description" => "Fiber size: 1.00–1.50 mm, Color: Dull brown/yellow, sometimes green streaks, Fair stripping and Comes from inner to outer leaf sheaths"
                ];
                break;
            case 'M1':
                $return = [
                    "Name" => "Medium Brown",
                    'Quality' => "Fair",
                    'Meaning' => "Dark, coarse fiber",
                    "Typical Uses" => "Agricultural twine, heavy ropes, low-grade pulp",
                    "Description" => "Fiber size: 1.00–1.50 mm, Color: Dark brown to almost black, Fair stripping, Usually from outer leaf sheaths"
                ];
                break;
            case 'Y2':
                $return = [
                    "Name" => "",
                    'Quality' => "Low",
                    'Meaning' => "Weak, stained, or residual fiber",
                    "Typical Uses" => "Brown packaging paper, stuffing, low-strength rope",
                    "Description" => "Residual fibers from grades H, JK, M1, Discolored or contaminated with defects, Lower strength and stiffness"
                ];
                break;
        }

        return $return;
    }
}
