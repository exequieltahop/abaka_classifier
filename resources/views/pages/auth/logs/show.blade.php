<x-auth-layout title="Logs - View Inferenced Image">
    <div class="container mx-auto px-3 mt-8">
        <div class="bg-white shadow-xl rounded-lg border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-violet-900 p-4 border-b border-violet-700">
                <div class="flex justify-between items-center">
                    <h5 class="text-white font-semibold flex items-center space-x-2 m-0">
                        <x-icon type="eye" class="text-lg" />
                        <span>View Details</span>
                    </h5>
                    <a href="{{ route('inferenced-images.index') }}"
                        class="flex items-center gap-1 text-white px-4 py-2 rounded-md transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="flex">
                <!-- Image Section -->
                <div class="flex justify-center bg-gray-50 p-6 border-b border-gray-200 w-[50%]">
                    <img src="{{ route('get.file', ['path' => urlencode($data->image_path), 'type' => urlencode('img-src')]) }}"
                        alt="abaca-image" class="w-full max-w-lg rounded shadow-md object-contain">
                </div>
                <!-- Details Section -->
                <div
                    class="p-6 space-y-6 w-full md:w-2/3 lg:w-1/2 mx-auto bg-white rounded-lg shadow-lg border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Prediction Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col">
                            <span class="text-gray-500 font-medium">Class Name</span>
                            <span
                                class="text-gray-900 mt-1">{{ $data->system_predicted_class . $data->description['Name'] }}</span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-gray-500 font-medium">Probability</span>
                            <span class="text-gray-900 mt-1">{{ $data->class_probability }}%</span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-gray-500 font-medium">Quality</span>
                            <span class="text-gray-900 mt-1">{{ $data->description['Quality'] }}</span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-gray-500 font-medium">Meaning</span>
                            <span class="text-gray-900 mt-1">{{ $data->description['Meaning'] }}</span>
                        </div>

                        <div class="flex flex-col md:col-span-2">
                            <span class="text-gray-500 font-medium">Typical Uses</span>
                            <span class="text-gray-900 mt-1">{{ $data->description['Typical Uses'] }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <span class="text-gray-500 font-medium">Details</span>
                        <p class="mt-2 text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-100 shadow-sm">
                            {{ $data->description['Description'] }}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-auth-layout>
