<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WfSequence;

class WfSequenceController extends Controller
{
    public static function append_data(WfSequence $wf_sequence)
    {
        $wf_sequence->current_state = $wf_sequence->current_state;
        $wf_sequence->next_state = $wf_sequence->next_state;
        return $wf_sequence;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $request->validate([
            'workflow_id' => 'required|integer|exists:workflows,id'
        ]);
        $wf_sequence = WfSequence::whereWorkflowId($request->workflow_id)->get();
        $wf_sequence->transform(function ($wf_sequence) {
            return self::append_data($wf_sequence);
        });
        return $wf_sequence;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        $request->validate([
            'workflow_id' => 'required|integer|exists:workflows,id',
            'wf_state_current_id' => 'required|integer|exists:wf_states,id',
            'wf_state_next_id' => 'required|integer|exists:wf_states,id',
        ]);

        $wf_sequence = WfSequence::create([
            'workflow_id' => $request->workflow_id,
            'wf_state_current_id' => $request->wf_state_current_id,
            'wf_state_next_id' => $request->wf_state_next_id,
            'action' => "Aprobar"
        ]);
        return response()->json(['message' => 'Registro creado exitosamente', 'data' => $wf_sequence], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WfSequence $wf_sequence)
    {
        return $this->append_data($wf_sequence);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WfSequence $wf_sequence)
    {
        $request->validate([
            'workflow_id' => 'integer|exists:workflows,id',
            'wf_state_current_id' => 'integer|exists:wf_states,id',
            'wf_state_next_id' => 'integer|exists:wf_states,id',
        ]);
        $wf_sequence->fill($request->all());
        $wf_sequence->save();
        return response()->json(self::append_data($wf_sequence), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WfSequence $wf_sequence)
    {
        $wf_sequence->delete();
        return response()->json([
            'message' => 'Registro eliminado correctamente'
        ], 200);
    }
}
