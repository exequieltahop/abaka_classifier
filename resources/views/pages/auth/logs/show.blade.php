<x-auth-layout title="Logs - View Inferenced Image">
    <div class="container mx-auto px-3 mt-5">
        <div class="w-full shadow-xl rounded-sm border border-gray-300">
            <div class="border border-x-0 border-t-0 border-b-gray-300 p-3">
                <div class="flex justify-between align-center">
                    <h5 class="text-primary font-medium m-0">
                        <x-icon type="eye" />
                        View Details
                    </h5>
                    <a href="{{route('inferenced-images.index')}}" class="block bg-violet-800 text-white px-3 py-1 rounded">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
            <div class="border border-gray-300 bg-white">
                <div class="flex justify-center mb-5 p-3">
                    <img src="{{route('get.file', ['path' => urlencode($data->image_path), 'type'=> urlencode('img-src')])}}" alt="abaca-image" class="w-full max-w-[500px]">
                </div>
                <hr class="text-gray-300">
                {{-- details --}}
                <div class="mb-5">
                    <div class="flex p-3 px-5 gap-2 pb-0">
                        <span class="font-medium">Class Name: </span>
                        <span>{{$data->system_predicted_class . $data->description['Name']}}</span>
                    </div>
                    <div class="flex p-3 px-5 gap-2 pb-0">
                        <span class="font-medium">Probability: </span>
                        <span>{{$data->class_probability}}%</span>
                    </div>
                    <div class="flex p-3 px-5 gap-2 pb-0">
                        <span class="font-medium">Quality: </span>
                        <span>{{$data->description['Quality']}}</span>
                    </div>
                    <div class="flex p-3 px-5 gap-2 pb-0">
                        <span class="font-medium">Meaning: </span>
                        <span>{{$data->description['Meaning']}}</span>
                    </div>
                    <div class="flex p-3 px-5 gap-2 pb-0">
                        <span class="font-medium">Typical Uses: </span>
                        <span>{{$data->description['Typical Uses']}}</span>
                    </div>
                    <div class="flex p-3 px-5 gap-2 pb-0">
                        <span class="font-medium">Details: </span>
                        <p>{{$data->description['Description']}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
