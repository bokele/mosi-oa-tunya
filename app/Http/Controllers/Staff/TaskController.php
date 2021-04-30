<?php

namespace App\Http\Controllers\Staff;

use DateTime;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = [];
        $user = auth()->user();
        $tasks = Task::where('user_id', $user->id)->get();
        foreach ($tasks as $task) {
            if (!$task->started_date) {
                continue;
            }

            $events[] = [
                'title' => $task->name,
                'start' => $task->started_date,
                'end' => $task->ended_date,
                'url'   => route('admin.tasks.edit', $task->id),
                'color' => "red"

            ];
        }
        return view('staff.tasks.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('staff.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TaskRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $user = auth()->user();
        $data_validated = $request->validated();



        $createStartDate = new DateTime($data_validated['started_date']);
        $start_date = $createStartDate->format('Y-m-d');

        $createEndDate = new DateTime($data_validated['ended_date']);
        $end_date = $createEndDate->format('Y-m-d');


        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);

        $end_date = Carbon::createFromFormat('Y-m-d', $end_date);
        if ($end_date->gte($start_date)) {
            $task = new Task;
            $task->name = $data_validated['name'];
            $task->description = $data_validated['description'];
            $task->started_date = $data_validated['started_date'];
            $task->ended_date = $data_validated['ended_date'];
            $task->status = $data_validated['status'];
            $task->user_id = $user->id;
            $task->save();
            return redirect()->route('admin.tasks.index')->with(['alert-type' => 'success', 'message' => 'The task has been successfull Added']);
        } else {
            return back()->with('error', 'End date must be greater than Start date');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('staff.tasks.create', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('staff.tasks.create', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\TaskRequest  $request
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $user = auth()->user();
        $data_validated = $request->validated();



        $createStartDate = new DateTime($data_validated['started_date']);
        $start_date = $createStartDate->format('Y-m-d');

        $createEndDate = new DateTime($data_validated['ended_date']);
        $end_date = $createEndDate->format('Y-m-d');


        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);

        $end_date = Carbon::createFromFormat('Y-m-d', $end_date);
        if ($end_date->gte($start_date)) {
            $task = new Task;
            $task->name = $data_validated['name'];
            $task->description = $data_validated['description'];
            $task->started_at = $data_validated['started_at'];
            $task->ended_at = $data_validated['ended_at'];
            $task->status = $data_validated['status'];
            $task->user_id = $user->id;
            $task->save();
            return redirect()->route('admin.tasks.index')->with(['alert-type' => 'success', 'message' => 'The task has been successfull Updated']);
        } else {
            return back()->with('error', 'End date must be greater than Start date');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('success', 'The task has been successfull Added');
    }
}
