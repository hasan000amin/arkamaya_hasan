<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::join('tb_m_client', 'tb_m_project.client_id', '=', 'tb_m_client.client_id')
                ->select('tb_m_project.*', 'tb_m_client.client_name')
                ->latest();

            return DataTables::of($data)
                ->addColumn('checkbox', function ($row) {
                    $check = '<input type="checkbox" name="project_ids[]" value="' . $row->project_id . '">';
                    return $check;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->project_id . '" data-name="' . $row->project_name . '" class="edit btn btn-primary btn-sm editProject">Edit</a>';
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('search') && !empty($request->get('search'))) {
                        $instance->where('project_name', 'like', '%' . $request->get('search') . '%');
                    }
                    if ($request->has('status') && !empty($request->get('status'))) {
                        $instance->where('project_status', '=', $request->get('status'));
                    }
                    if ($request->has('client') && !empty($request->get('client'))) {
                        $instance->where('client_name', '=', $request->get('client'));
                    }
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }

        $clients = Client::get();
        $projects = Project::select('project_status')->get();
        return view('project.index', compact('clients', 'projects'));
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Project::whereIn('project_id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil di hapus']);
    }

    public function edit($id)
    {
        $project = Project::join('tb_m_client', 'tb_m_project.client_id', '=', 'tb_m_client.client_id')
            ->select('tb_m_project.*', 'tb_m_client.client_name')
            ->find($id);
        return response()->json($project);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'project_name' => 'required',
            'client_id' => 'required',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //create project
        $project = Project::updateOrCreate(
            ["project_id" => $request->project_id],
            [
                "project_name" => $request->project_name,
                "client_id" => $request->client_id,
                "project_start" => $request->project_start,
                "project_end" => $request->project_end,
                "project_status" => $request->project_status,
            ]
        );

        //return response JSON project is created
        if ($project) {
            return response()->json([
                'success' => true,
                'project'    => $project,
                'message' => 'Berhasil disimpan'
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
            'message' => 'Gagal disimpan'
        ], 409);
    }
}
