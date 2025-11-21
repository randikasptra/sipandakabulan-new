<div class="bg-white shadow-md border border-gray-200 rounded-xl p-5">
    <div class="flex items-center gap-2 mb-3">
        <i class="bi bi-activity text-blue-600"></i>
        <span class="font-semibold text-gray-700">Evaluasi Berlangsung</span>
    </div>

    <div class="w-full bg-gray-200 h-3 rounded-full mb-3">
        <div class="bg-blue-600 h-3 rounded-full" style="width: {{ number_format($totalProgress, 0) }}%">
        </div>
    </div>

    <div class="flex justify-between text-sm text-gray-600">
        <span>{{ number_format($totalProgress, 0) }}%</span>
        <span>Maksimal: <b>{{ number_format($totalMax) }}</b></span>
    </div>

    <div class="text-sm text-gray-600 mt-2">
        Nilai EM: <b>{{ number_format($totalEm, 2) }}</b>
    </div>
</div>
