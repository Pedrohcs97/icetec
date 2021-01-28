<?php

namespace App\Http\Controllers;

use App\Candidato;
use App\Tecnologia;
use App\TecnologiaCandidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidatoController extends Controller
{

    protected $candidato;

    public function __construct(Candidato $candidato)
    {
        $this->candidato = $candidato;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tecnologias = Tecnologia::get();
        $request = $request->all();

        if (isset($request['tecnologia']) && is_int(json_decode($request['tecnologia']))) {
            $tec = Tecnologia::find($request['tecnologia']);
            $candidatos = $tec->candidatos;
            $tecSelected = $request['tecnologia'];
        } else
            $candidatos = $this->candidato->get();

        return view('candidato.list', compact("candidatos", "tecnologias", "tecSelected"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tecnologias = Tecnologia::get();
        return view('candidato.form', compact('tecnologias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        if (!empty($request->only(['tecnologias']))) {
            $tecnologias = $request->only(['tecnologias']);
            $tecnologias = $tecnologias['tecnologias'];
        }

        $request = $request->all();

        $validator = validator($request, Candidato::$rules);

        if ($validator->fails()) {
            return redirect('/candidato/create')
                ->withErrors($validator)
                ->withInput($request);
        }

        $insert = $this->candidato->create($request);

        if (!empty($tecnologias)) {
            $insert->tecnologias()->sync($tecnologias);
        }

        if ($insert) {
            DB::commit();
            $notification = array(
                'message' => 'Canditato cadastrado com sucesso!',
                'alert-type' => 'success'
            );
            return redirect('/candidato')->with($notification);
        } else {
            DB::rollBack();
            $notification = array(
                'message' => 'Falha ao cadastrar candidato!',
                'alert-type' => 'error'
            );
            return redirect('/candidato/create')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function show(Candidato $candidato)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tecnologias = Tecnologia::get();
        $candidato = $this->candidato->find($id);
        $tecsSelected = $candidato->tecnologias()->get();
        return view('candidato.form', compact('candidato', 'tecnologias', 'tecsSelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        if (!empty($request->only(['tecnologias']))) {
            $tecnologias = $request->only(['tecnologias']);
            $tecnologias = $tecnologias['tecnologias'];
        }

        $validator = validator($request->all(), Candidato::$rules);
        if ($validator->fails()) {
            return redirect("/candidato/{$id}/edit")
                ->withErrors($validator)
                ->withInput();
        }

        $candidato = $this->candidato->find($id);
        $update = $candidato->update($request->all());

        if (!empty($tecnologias)) {
            $candidato->tecnologias()->sync($tecnologias);
        } else {
            TecnologiaCandidato::select('*')
                ->where(['candidato_id', '=', $id])
                ->delete();
        }


        if ($update) {
            DB::commit();
            $notification = array(
                'message' => 'Candidato alterado com sucesso!',
                'alert-type' => 'success'
            );
            return redirect('candidato')->with($notification);
        } else {
            DB::rollBack();
            $notification = array(
                'message' => 'Falha ao alterar candidato!',
                'alert-type' => 'error'
            );
            return redirect("/candidato/{$id}/edit")
                ->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $candidato = $this->candidato->find($id);
            DB::table('tecnologias_candidatos')->where('candidato_id', '=', $id)->delete();

            $delete = $candidato->delete($candidato);

            if ($delete) {
                DB::commit();
                $notification = array(
                    'message' => 'Candidato excluído com sucesso!',
                    'alert' => 'success'
                );
                return redirect('/candidato');
                // return response()->json($notification);
            } else {
                DB::rollBack();
                $notification = array(
                    'message' => 'Falha ao excluir Candidato!',
                    'alert' => 'error'
                );
                return redirect('/candidato');
                // return response()->json($notification);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $erro = $e->errorInfo;
            if ($erro[1] == 1451) {
                $notification = array(
                    'message' => 'Registro não pode ser excluído pois está vinculado a outro registro!',
                    'alert' => 'error'
                );
                return redirect('/candidato');
                // return response()->json($notification);
            }
        }
    }
}
