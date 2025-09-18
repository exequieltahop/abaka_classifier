<x-auth-layout title="Logs">
    <div class="container mx-auto">
        <div class="w-full shadow-xl rounded-sm border border-gray-300">
            <div class="border border-x-0 border-t-0 border-b-gray-300 p-3">
                <h5 class="text-primary font-medium">
                    <x-icon type="history"/>
                    Logs
                </h5>
            </div>
            <div class="overflow-x-auto px-4">
                <table class="table-auto border-collapse w-full text-left text-primary">
                    <thead class="border border-x-0 border-t-0 border-b-gray-300 ">
                        <tr>
                            <th class="p-2">Class</th>
                            <th class="p-2">Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @while ($count != 10)
                            <tr class="hover:bg-gray-100">
                                <td class="p-1">Grade A</td>
                                <td class="p-1">{{Carbon\Carbon::now()->format('F j, Y')}}</td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                        @endwhile
                    </tbody>
                </table>
            </div>
            {{-- pagination --}}
            <div class="w-full p-3 flex align-center justify-end border border-x-0 border-b-0 border-t-gray-300">
                <a href="" class="px-3 py-1 bg-violet-800 text-white font-sm rounded-tl-sm rounded-bl-sm">
                    < Prev
                </a>
                <div class="flex align-center">
                    <a href="" class="px-3 py-1 text-primary font-sm border border-violet-800">
                        1
                    </a>
                    <a href="" class="px-3 py-1 text-primary font-sm border border-violet-800">
                        2
                    </a>
                    <a href="" class="px-3 py-1 text-primary font-sm border border-violet-800">
                        3
                    </a>
                </div>
                <a href="" class="px-3 py-1 bg-violet-800 text-white font-sm rounded-tr-sm rounded-br-sm">
                    Next >
                </a>
            </div>
        </div>
    </div>
</x-auth-layout>
