<?php

namespace App\Http\Controllers;

use App\Category;
use App\Contest;
use App\Contestant;
use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade as Newsletter;

class MyContestantController extends Controller
{
    public function index()
    {
        $contestants = auth()->user()->contestants;
        $contest = Contest::whereActive(true)->first();

        return view('mycontestants.index', [
            'contestants' => $contestants,
            'contest'     => $contest,
        ]);
    }

    public function show()
    {
        return redirect()->route('mycontestants.index');
    }

    public function create()
    {
        $categories = Contest::whereActive('1')->get()->first()->categories()->get();
        $contest = Contest::whereActive(true)->first();

        return view('mycontestants.create', [
            'categories' => $categories,
            'contest'    => $contest,
        ]);
    }

    public function edit(Contestant $contestant)
    {
        $contest = Contest::whereActive(true)->first();
        $categories = $contest->categories;

        return view('mycontestants.edit', [
            'contestant' => $contestant,
            'contest'    => $contest,
            'categories' => $categories,
        ]);
    }

    public function update(Contestant $contestant)
    {

        $req = request()->validate([
            'name'      => 'required',
            'last_name' => 'required',
            'dob'       => 'required',
            // 'email'     => 'email',
            // 'motivo'    =>'string'
        ]);
        $contestantUpdate = [
            // 'representant_id' => auth()->user()->id,
            'name'            => request()->name,
            'last_name'       => request()->last_name,
            'dob'             => request()->dob,
            'motivo'          => request()->motivo,
            'email'           => request()->email,
        ];
        

        $activeContest = Contest::whereActive(true)->first();
        

        $contestCatsId = Contest::whereActive(true)->first()->categories->pluck('id');
        $status = $this->verifyStatus($contestant->dob, request('categoryId'));

        $contestant->category()->detach($contestCatsId);
        $contestant->category()->attach([request()->categoryId=> ['status'=>$status]]);
        $contestant->update($contestantUpdate);
        

        if (request('email')) {
            Newsletter::subscribe(request('email'), ['firstName'=>request('name'), 'lastName'=>request('last_Name')], 'contestants');
        }
        return route('mycontestants.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'last_name' => 'required',
            'dob'       => 'required',
            // 'email'     => 'email',
            // 'motivo'    =>'string'
        ]);

        $contestant = [
            'representant_id' => auth()->user()->id,
            'name'            => $request->name,
            'last_name'       => $request->last_name,
            'dob'             => $request->dob,
            'motivo'          => $request->motivo,
            'email'           => $request->email,
        ];
        $contestant = Contestant::create($contestant);
        if (request('email')) {
            Newsletter::subscribe($request->email, ['firstName'=>$request->name, 'lastName'=>$request->lastName], 'contestants');
        }
        $status = $this->verifyStatus($contestant->dob, $request->categoryId);
        $contestant->category()->attach($request->categoryId, ['status'=>$status]);

        return redirect()->route('mycontestants.index');
    }

    public function verifyStatus($dob, $categoryId)
    {
        $cat = Category::find($categoryId);

        $age = \Carbon\Carbon::now()->diffInYears($dob);
        $response = '';
        switch ($cat->name) {
            case 'Seeds':
            if ($age >= 0 && $age <= $cat->max_age) {
                $response = 'approved';
            }
            break;
            case 'Sprouts':
            if ($age >= 4 && $age <= $cat->max_age) {
                $response = 'approved';
            }
            break;
            case 'Thinkers':
            if ($age >= 8 && $age <= $cat->max_age) {
                $response = 'approved';
            }
            break;
            case 'Game Changers':
            if ($age >= 11 && $age <= $cat->max_age) {
                $response = 'approved';
            }
            break;
            default:
            $response = 'pending';
            break;
        }
        if ($response === '') {
            return 'pending';
        }

        return $response;
    }
}
