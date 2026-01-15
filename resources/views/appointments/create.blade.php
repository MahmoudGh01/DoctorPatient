<x-site-layout title="Create Appointment">

    {{-- PAGE HEADER --}}
    <div class="max-w-6xl mx-auto mb-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800">Create a New Appointment</h1>
        <p class="text-gray-600">Choose a cabinet, review doctor details, and select a time slot.</p>
    </div>





    {{-- TWO-COLUMN LAYOUT --}}
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 px-4">

        {{-- CALENDAR SECTION --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">📅 Select a Time Slot</h2>

            <div id="calendar" class="rounded-lg overflow-hidden border border-gray-300 max-h-[650px]"></div>
        </div>


        {{-- FORM SECTION --}}

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 lg:sticky lg:top-10 h-fit">

            <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 Appointment Details</h2>
            {{-- CABINET + DOCTOR DETAILS --}}
            <div class="max-w-6xl mx-auto px-4 mb-10">
                <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6">

                    <div class="flex items-start gap-6">

                        {{-- Doctor Photo --}}
                        <img
                            src="{{ $cabinet->doctor->getFirstMediaUrl('profile')
                        ?: 'https://ui-avatars.com/api/?size=150&name=' . urlencode($cabinet->doctor->name) }}"
                            class="w-28 h-28 rounded-full object-cover border shadow"
                            alt="Doctor photo"
                        >

                        {{-- Text Info --}}
                        <div class="flex-1">

                            {{-- Cabinet Name --}}
                            <h2 class="text-2xl font-bold text-gray-800 mb-1">
                                {{ $cabinet->name }}
                            </h2>

                            {{-- Location --}}
                            @if($cabinet->location)
                                <p class="text-gray-600 mb-3">
                                    📍 {{ $cabinet->location }}
                                </p>
                            @endif

                            {{-- Doctor --}}
                            <div class="mt-4">
                                <p class="text-gray-500 text-sm">Doctor in charge</p>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $cabinet->doctor->name }}
                                </p>
                                <p class="text-gray-600">
                                    {{ $cabinet->doctor->email }}
                                </p>

                                @if($cabinet->doctor->specialty ?? false)
                                    <p class="text-teal-700 font-medium mt-1">
                                        🩺 {{ $cabinet->doctor->specialty }}
                                    </p>
                                @endif
                            </div>

                            {{-- Optional description --}}
                            @if($cabinet->description)
                                <p class="mt-5 text-gray-700 text-sm leading-relaxed">
                                    {{ $cabinet->description }}
                                </p>
                            @endif

                        </div>

                    </div>

                </div>
            </div>
            <form action="/appointments" method="POST" class="space-y-5">
                @csrf

                {{-- Hidden cabinet ID --}}
                <input type="hidden" name="cabinet_id" value="{{ $cabinet->id }}" />

                <input type="hidden" name="status" value="scheduled">


                {{-- Datetime Picker --}}
                <x-date-time-picker name="datetime" label="Selected Date & Time" />

                {{-- Preview --}}
                <p id="selectedDatePreview" class="text-gray-700 font-medium"></p>

                {{-- Submit --}}
                <button
                    class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 shadow-md transition font-semibold">
                    Create Appointment
                </button>

            </form>

        </div>
    </div>


    {{-- FULLCALENDAR SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                selectable: true,

                height: "650px",
                contentHeight: "auto",
                expandRows: true,

                slotDuration: "00:30:00",
                slotMinTime: "08:00:00",
                slotMaxTime: "18:00:00",
                allDaySlot: false,


                events: '/api/calendar/appointments?cabinet_id={{ $cabinet->id }}',

                select: function(info) {
                    const date = info.start.toISOString().slice(0, 10);
                    const time = info.start.toTimeString().slice(0, 5);

                    const formatted = `${date} ${time}:00`;

                    // Fill DateTimePicker
                    document.querySelector('[name="datetime"]').value = formatted;

                    // Live preview
                    document.getElementById('selectedDatePreview').innerText =
                        "Selected: " + formatted;
                },

                eventClick: function() {
                    alert('This slot is already booked.');
                },

                eventColor: '#ef4444',
            });

            calendar.render();
        });
    </script>

</x-site-layout>
