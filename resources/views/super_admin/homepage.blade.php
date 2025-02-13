<x-layout>
    <link rel="stylesheet" href="/src/output.css">
    <link rel="stylesheet" href="/src/custom.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/adapter/7.0.0/adapter.min.js"></script>
    <div class="page-inner auto-refresh-dashboard" style="padding-left:50px;">

        <!-- Main content -->
        <h2 class="text-xl font-semibold mb-4">Appointments</h2>
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg flex items-center min-h-[150px]">
                <i class="fas fa-users text-blue-600 text-2xl mr-3"></i>
                <div class="text-center flex-1">
                    <span class="text-2xl font-bold">{{ $totalLaboratory?? 'N/A' }}</span>
                    <p class="text-zinc-600">Laboratory</p>
                </div>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg flex items-center min-h-[150px]">
                <i class="fas fa-clock text-yellow-600 text-2xl mr-3"></i>
                <div class="text-center flex-1">
                    <span class="text-2xl font-bold">{{ $totalConsultation?? 'N/A' }}</span>
                    <p class="text-zinc-600">Consultation</p>
                </div>
            </div>
            <div class="bg-green-100 p-4 rounded-lg flex items-center min-h-[150px]">
                <i class="fas fa-check text-green-600 text-2xl mr-3"></i>
                <div class="text-center flex-1">
                    <span class="text-2xl font-bold">{{ $totalVaccination ?? 'N/A' }}</span>
                    <p class="text-zinc-600">Vaccination</p>
                </div>
            </div>
            <div style="height: 15rem" class="bg-zinc-100 p-4 rounded-lg flex items-center min-h-[150px]">
                <i class="fas fa-tasks text-zinc-600 text-2xl mr-3"></i>
                <div class="text-center flex-1">
                    <span class="text-2xl font-bold">{{ $totalBlood ?? 'N/A' }}</span>
                    <p class="text-zinc-600">Blood Donation</p>
                </div>
            </div>
        </div>

    </div>
    <script src="/src/javascript/blood.js"></script>
</x-layout>
