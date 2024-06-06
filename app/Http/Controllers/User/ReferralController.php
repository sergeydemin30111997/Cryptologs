<?php

namespace App\Http\Controllers\User;

use App\Models\Referral;
use App\Models\SettingsSite;
use App\Models\User;
use Illuminate\Http\Request;
class ReferralController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listUsersReferral = Referral::where('partner_id', $this->user->id)->orderBy('updated_at', 'desc')->paginate(10)->onEachSide(1);
        $incineration = SettingsSite::where('item_key', 'balance_burn_percentage')->first()->value;
        return view('user.referrals', compact('listUsersReferral', 'incineration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        if(!empty($request->incineration) && $this->user->can('attracting_referrals')) {
            if (0 < $request->incineration && $request->incineration <= 100) {
                $incineration = SettingsSite::where('item_key', 'balance_burn_percentage')->first();
                $incineration->value = $request->incineration;
                $incineration->save();
            }
        }
        $referal_benefit = Referral::where('referral_id', $id)->first();
        $is_partner = $this->user->getPartner($id);
        if (!empty($request->benefit) && $referal_benefit && $is_partner->id == $this->user->id && !$referal_benefit->edited) {
            if ($request->benefit > 0 && $request->benefit <= 100) {
                $referal_benefit->benefit = $request->benefit;
                $referal_benefit->edited = 1;
                $referal_benefit->save();
            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }
}
