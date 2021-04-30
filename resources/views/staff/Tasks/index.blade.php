<x-app-layout>
    @section('page-title')
    Tasks | Event |
    @endsection
    <x-slot name="header">

        <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">{{ __('Tasks') }}</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home">{{_("Home") }}</a>
                </li>
                <li class="breadcrumb-item active">{{_("tasks")}}</li>
            </ol>
        </div>
        <!-- /.col -->
    </x-slot>
    <div class="card">
        <div class="card-header">
            {{ __('Calendar') }}
            <div class="card-tools">
                <a href="{{ route('admin.tasks.create')}} " class="btn btn-dark">
                    <i class="fas fa-plus fa-lg"></i> &nbsp;
                    {{_(" Add New Task")}}
                </a>
            </div>
        </div>

        <div class="card-body">



            <div id='calendar'></div>






        </div>
    </div>


    @push('scripts')

    <script>
        $(document).ready(function () {
        // page is now ready, initialize the calendar...
        var calendarEl = document.getElementById('calendar');
        events ={!! json_encode($events) !!};
  var calendar = new FullCalendar.Calendar(calendarEl, {
          // put your options and callbacks here
         timeZone: 'UTC',
        themeSystem: 'bootstrap',
       eventColor: 'green',
       initialView: 'dayGridMonth',
        headerToolbar: {
        left: 'prev,next today',

        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        dateClick: function(info) {
alert('clicked ' + info.dateStr);
        },
        select: function(info) {
        alert('selected ' + info.startStr + ' to ' + info.endStr);
        },
        weekNumbers: true,
        dayMaxEvents: true, // allow "more"
          events: events,
         editable: true,


        });
        calendar.render();
        // new Draggable(draggableEl);
      })
    </script>

    @endpush
</x-app-layout>
