<x-app-layout title="Edit Appointment Status">

    <div class="max-w-xl mx-auto px-6 py-10">

        <div class="bg-white border border-gray-200 shadow rounded-xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Update Appointment Status
            </h1>

            <form action="{{ route('doctor.appointments.update', $appointment->id) }}"
                  method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Status</label>

                    <select name="status"
                            class="w-full border border-gray-300 rounded-lg p-2">
                        <option value="scheduled" {{ $appointment->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <button class="w-full bg-teal-600 text-white py-3 rounded-lg shadow hover:bg-teal-700">
                    Update Status
                </button>
            </form>

        </div>

    </div>

</x-app-layout>
