<?php


namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Item;
use App\Materials;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaterialsControllerEmployee extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $materials=Materials::whereVisible(1)->get();

        return view('employee.materials.index')->with('materials', $materials);
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:20',
                Rule::unique('materials')->where(function ($query) {
                    return $query;
                })->where('visible',1),  ]
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.',
            'name.unique' => 'Material already exists.',
            'name.max' => 'Maximum length of name is 30 characters',
        ];

        $this->validate($request, $rules, $customMessages);

        $material= new Materials();
        $material->name=ucfirst(strtolower($request['name']));
        $material->visible=1;
        $material->save();

        return back();
    }

    public function delete($locale,$id)
    {
        $material = Materials::whereId($id)->first();

        $item = Item::where('material', $material->id)->orWhere('sidePanel', $material->id)->orWhere('collar', $material->id)->count();
        if ($item == 0)
        {
            $material->visible = 0;
            $material->save();
            return back()->with('success', "Material - ".$material->name." was successfully removed.");
        }else {
            return back()->with('error', "You can not delete material which is already used.");
        }
    }
}
