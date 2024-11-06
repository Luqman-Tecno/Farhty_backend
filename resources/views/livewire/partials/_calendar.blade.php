@push('styles')
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css' rel='stylesheet' />
<style>
    .fc {
        direction: rtl;
        font-family: 'Cairo', sans-serif;
    }
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1.5em;
        background: #F9FAFB;
        padding: 1rem;
        border-radius: 0.5rem;
    }
    .fc .fc-button-primary {
        background-color: #581C87;
        border-color: #581C87;
    }
    .fc .fc-button-primary:hover {
        background-color: #6B21A8;
        border-color: #6B21A8;
    }
    .fc .fc-button-primary:disabled {
        background-color: #9333EA;
        border-color: #9333EA;
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(139, 92, 246, 0.1);
    }
    .fc-event {
        cursor: pointer;
    }
</style>
@endpush

<div wire:ignore>
    <div id="calendar" class="bg-white rounded-xl p-4"></div>
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/main.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ar-sa',
        direction: 'rtl',
        headerToolbar: {
            start: 'prev,next today',
            center: 'title',
            end: ''
        },
        buttonText: {
            today: 'اليوم'
        },
        firstDay: 6,
        selectable: true,
        events: @json($this->getCalendarEvents()),
        dateClick: function(info) {
            @this.selectDate(info.dateStr);
        },
        selectConstraint: {
            start: '{{ Carbon\Carbon::now()->format("Y-m-d") }}',
            end: '{{ Carbon\Carbon::now()->addMonths(6)->format("Y-m-d") }}'
        }
    });
    calendar.render();
});
</script>
@endpush 