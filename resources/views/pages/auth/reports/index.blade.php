<x-auth-layout title="Reports">

    <x-container>
        {{-- statistics --}}
        <section class="">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-bold text-violet-900">Statistics Overview</h2>
                    <p class="text-sm text-gray-500">
                        Summary of system users, validations, and accuracy results
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-4">
                @if (auth()->user()->role == 1)
                <!-- Card 1 -->
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                                basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Users</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $total_users }}</span>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                                basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Expert</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $total_experts }}</span>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                                basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Regular User</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $total_regular_users }}</span>
                    </div>
                </div>
                @endif

                <!-- Card 4 -->
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                            basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Validated Image</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $validated_images }}</span>
                    </div>
                </div>
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                            basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Unvalidated Image</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $unvalidated_images }}</span>
                    </div>
                </div>
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                            basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Accurate Validation</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $accurate_validation }}</span>
                    </div>
                </div>
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                            basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Less Accurate Validation</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $less_accurate_validation }}</span>
                    </div>
                </div>
                <div class="p-4 shadow-md rounded-sm border border-gray-200 border-r-violet-900 border-r-5 border-l-5 border-l-violet-900
                            basis-full sm:basis-[48%] lg:basis-[24%]">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <x-icon type="users text-violet-900" />
                            <h5 class="font-medium text-md text-violet-500">Not Accurate Validation</h5>
                        </div>
                        <span class="text-4xl text-violet-900 font-bold text-end">{{ $not_accurate_validation }}</span>
                    </div>
                </div>

            </div>
        </section>

        {{-- chart --}}
        <section class="p-4 border border-gray-200 shadow-md rounded-md mt-5">

            <div class="mb-5">
                <h2 class="text-xl font-bold text-violet-900">
                    Abaca Gradings per Barangay
                </h2>
                <p class="text-sm text-gray-500">
                    Distribution of abaca fiber grades by barangay
                </p>
            </div>

            <form action="">
                <select name="year-filter" id="year-filter"
                    class="text-md font-medium p-[1em] text-violet-900 border border-gray-200 w-full max-w-[500px] rounded-md focus:outline-gray-200">
                    <option value="">-- Select Year --</option>
                    @for ($i = now()->year; $i >= 1990; $i--)
                    @if ($i == now()->year)
                    <option value="{{ $i }}" selected>{{ $i }}</option>
                    @else
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endif

                    @endfor
                </select>
            </form>

            <div class="w-full overflow-x-auto mt-4">
                <canvas id="chart1" class="min-h-[500px] h-full"></canvas>
            </div>
        </section>

    </x-container>


    {{-- script --}}
    <script>
        let chart1Instance = null;

        document.addEventListener('DOMContentLoaded', function () {
            renderChart1();

            document.getElementById('year-filter')
                .addEventListener('change', renderChart1);
        });

        const renderChart1 = async () => {

            const labels = [
                'BENIT', 'BUAC DAKU', 'BUAC GAMAY', 'CABADBARAN', 'CONCEPCION',
                'CONSOLACION', 'DAGSA', 'HIBOD-HIBOD', 'HINDANGAN', 'HIPANTAG',
                'JAVIER', 'KAHUPIAN', 'KANANGKAAN', 'KAUSWAGAN', 'LP CONCEPCION',
                'LIBAS', 'LOM-AN', 'MABICAY', 'MAAC', 'MAGATAS', 'MAHAYAHAY',
                'MALINAO', 'MARIA PLANA', 'MILAGROSO', 'OLISIHAN', 'PANCHO VILLA',
                'PANDAN', 'RIZAL', 'SALVACION', 'SF MABUHAY', 'SAN ISIDRO',
                'SAN JOSE', 'SAN JUAN (AGATA)', 'SAN MIGUEL', 'SAN PEDRO',
                'SAN ROQUE', 'SAN VICENTE', 'SANTA MARIA', 'SUBA', 'TAMPOONG',
                'ZONE I', 'ZONE II', 'ZONE III', 'ZONE IV', 'ZONE V'
            ];

            const grades = {
                SS2: { label: "SS2 – Spindle S2", color: "#16a34a" },
                S2: { label: "S2 – Streaky Two", color: "#22c55e" },
                SS3: { label: "SS3 – Spindle S3", color: "#0ea5e9" },
                S3: { label: "S3 – Streaky Three", color: "#0284c7" },
                I: { label: "I – Current Grade", color: "#eab308" },
                G: { label: "G – Soft Seconds", color: "#f59e0b" },
                T: { label: "T – Tow", color: "#ef4444" },
                JK: { label: "JK – Seconds", color: "#f97316" },
                M1: { label: "M1 – Medium Brown", color: "#78350f" },
                Y2: { label: "Y2 – Residual", color: "#6b7280" }
            };

            const year = document.getElementById('year-filter').value;

            const response = await axios.get(`/get-chart-data?year=${year}`);
            const rawData = response.data;

            const dataMap = {};

            rawData.forEach(item => {
                const brgy = item.brgy.trim().toUpperCase();
                const grade = item.system_predicted_class;
                const total = item.total;

                if (!dataMap[brgy]) dataMap[brgy] = {};
                dataMap[brgy][grade] = total;
            });

            const datasets = Object.entries(grades).map(([gradeKey, grade]) => ({
                label: grade.label,
                backgroundColor: grade.color,
                stack: 'stack1',
                data: labels.map(brgy => dataMap?.[brgy]?.[gradeKey] ?? 0)
            }));

            const config = {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { stacked: true },
                        y: {
                            stacked: true,
                            title: { display: true, text: 'Quantity' }
                        }
                    }
                }
            };

            const canvas = document.getElementById('chart1');
            const ctx = canvas.getContext('2d');

            if (chart1Instance) {
                chart1Instance.destroy();
            }

            chart1Instance = new Chart(ctx, config);
        };


        const chartData = async () => {
            try {
                const data = await axios.get(`/get-chart-data`);

                return data;
            } catch (error) {
                console.error(error);
                Toastify({
                    text: "Server Error, Something went wrong",
                    duration: 2000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: 'left',
                    stopOnFocus: true,
                    style: {
                        background: "rgb(225,100,100)"
                    }
                }).showToast();
                return;
            }
        }
    </script>
</x-auth-layout>