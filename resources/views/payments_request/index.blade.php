@extends('template.app')

@section('title', __('payment_requests.title'))

@section('header')

@endsection

@section('content')
    <main class="dashboard_content dashboard_content-norightsidebar">
        <div class="mx_title">
            <h2 class="ttl">@lang('payment_requests.table_name')</h2>
        </div>
        <div class="dash_list dash_list-dropmoneyrequests">
            <div class="row row-title">
                @can('payment_request')
                    <div class="cell">
                        @lang('payment_requests.table_telegram')
                    </div>
                @endcan
                <div class="cell">
                    @lang('payment_requests.table_sum')
                </div>
                <div class="cell">
                    @lang('payment_requests.table_wallet')
                </div>
                <div class="cell">
                    @lang('payment_requests.table_status')
                </div>
                <div class="cell">
                    @lang('payment_requests.table_time')
                </div>
            </div>
            @foreach($payment_request as $payment_item)
                @foreach($data_users as $data_item)
                    @if($data_item->id_telegram == $payment_item->telegram_id)
                        <div class="row">
                            @can('payment_request')
                                <div class="cell">
                                    <a href="{{ route('user_data.show', $data_item->id) }}">{{ '@'.$data_item->name_telegram }}</a>
                                </div>
                            @endcan
                            <div class="cell">
                                ${{ $payment_item->sum }}
                            </div>
                            <div class="cell">
                                {{ $payment_item->wallet_name }}
                            </div>
                            <div class="cell">
                                @if($payment_item->status_payment == 'payout')
                                    <div class="status_span status_span-green">
                                        {{ __('payment_requests.'.$payment_item->status_payment) }}
                                    </div>
                                @else
                                    <div class="status_span status_span-red">
                                        {{ __('payment_requests.'.$payment_item->status_payment) }}
                                    </div>
                                @endif
                            </div>
                            <div class="cell">
                                {{ $payment_item->created_at }}
                                @can('payment_request')
                                    @if($payment_item->status_payment == 'pending')
                                        <form
                                            action="{{ route('payments_request.update', $payment_item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="return" value="true">
                                            <button type="submit" class="btn green" title="Выплачено">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     viewBox="0 0 14 14" fill="none">
                                                    <path
                                                        d="M7.00004 0.333374C3.32671 0.333374 0.333374 3.32671 0.333374 7.00004C0.333374 10.6734 3.32671 13.6667 7.00004 13.6667C10.6734 13.6667 13.6667 10.6734 13.6667 7.00004C13.6667 3.32671 10.6734 0.333374 7.00004 0.333374ZM10.1867 5.46671L6.40671 9.24671C6.31337 9.34004 6.18671 9.39337 6.05337 9.39337C5.92004 9.39337 5.79337 9.34004 5.70004 9.24671L3.81337 7.36004C3.62004 7.16671 3.62004 6.84671 3.81337 6.65337C4.00671 6.46004 4.32671 6.46004 4.52004 6.65337L6.05337 8.18671L9.48004 4.76004C9.67337 4.56671 9.99337 4.56671 10.1867 4.76004C10.38 4.95337 10.38 5.26671 10.1867 5.46671Z"
                                                        fill="white"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('payments_request.destroy', $payment_item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="return" value="true">
                                            <button type="submit" class="btn red" title="Отменить с возвратом">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M14.0466 3.48671C12.9733 3.38004 11.8999 3.30004 10.8199 3.24004V3.23337L10.6733 2.36671C10.5733 1.75337 10.4266 0.833374 8.86661 0.833374H7.11994C5.56661 0.833374 5.41994 1.71337 5.31328 2.36004L5.17328 3.21337C4.55328 3.25337 3.93328 3.29337 3.31328 3.35337L1.95328 3.48671C1.67328 3.51337 1.47328 3.76004 1.49994 4.03337C1.52661 4.30671 1.76661 4.50671 2.04661 4.48004L3.40661 4.34671C6.89994 4.00004 10.4199 4.13337 13.9533 4.48671C13.9733 4.48671 13.9866 4.48671 14.0066 4.48671C14.2599 4.48671 14.4799 4.29337 14.5066 4.03337C14.5266 3.76004 14.3266 3.51337 14.0466 3.48671Z"
                                                        fill="white"/>
                                                    <path
                                                        d="M12.82 5.42663C12.66 5.25996 12.44 5.16663 12.2134 5.16663H3.7867C3.56004 5.16663 3.33337 5.25996 3.18004 5.42663C3.0267 5.59329 2.94004 5.81996 2.95337 6.05329L3.3667 12.8933C3.44004 13.9066 3.53337 15.1733 5.86004 15.1733H10.14C12.4667 15.1733 12.56 13.9133 12.6334 12.8933L13.0467 6.05996C13.06 5.81996 12.9734 5.59329 12.82 5.42663ZM9.1067 11.8333H6.8867C6.61337 11.8333 6.3867 11.6066 6.3867 11.3333C6.3867 11.06 6.61337 10.8333 6.8867 10.8333H9.1067C9.38004 10.8333 9.6067 11.06 9.6067 11.3333C9.6067 11.6066 9.38004 11.8333 9.1067 11.8333ZM9.6667 9.16663H6.33337C6.06004 9.16663 5.83337 8.93996 5.83337 8.66663C5.83337 8.39329 6.06004 8.16663 6.33337 8.16663H9.6667C9.94004 8.16663 10.1667 8.39329 10.1667 8.66663C10.1667 8.93996 9.94004 9.16663 9.6667 9.16663Z"
                                                        fill="white"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route('payments_request.destroy', $payment_item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn red" title="Отменить без возврата">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M14.0466 3.48671C12.9733 3.38004 11.8999 3.30004 10.8199 3.24004V3.23337L10.6733 2.36671C10.5733 1.75337 10.4266 0.833374 8.86661 0.833374H7.11994C5.56661 0.833374 5.41994 1.71337 5.31328 2.36004L5.17328 3.21337C4.55328 3.25337 3.93328 3.29337 3.31328 3.35337L1.95328 3.48671C1.67328 3.51337 1.47328 3.76004 1.49994 4.03337C1.52661 4.30671 1.76661 4.50671 2.04661 4.48004L3.40661 4.34671C6.89994 4.00004 10.4199 4.13337 13.9533 4.48671C13.9733 4.48671 13.9866 4.48671 14.0066 4.48671C14.2599 4.48671 14.4799 4.29337 14.5066 4.03337C14.5266 3.76004 14.3266 3.51337 14.0466 3.48671Z"
                                                        fill="white"/>
                                                    <path
                                                        d="M12.82 5.42663C12.66 5.25996 12.44 5.16663 12.2134 5.16663H3.7867C3.56004 5.16663 3.33337 5.25996 3.18004 5.42663C3.0267 5.59329 2.94004 5.81996 2.95337 6.05329L3.3667 12.8933C3.44004 13.9066 3.53337 15.1733 5.86004 15.1733H10.14C12.4667 15.1733 12.56 13.9133 12.6334 12.8933L13.0467 6.05996C13.06 5.81996 12.9734 5.59329 12.82 5.42663ZM9.1067 11.8333H6.8867C6.61337 11.8333 6.3867 11.6066 6.3867 11.3333C6.3867 11.06 6.61337 10.8333 6.8867 10.8333H9.1067C9.38004 10.8333 9.6067 11.06 9.6067 11.3333C9.6067 11.6066 9.38004 11.8333 9.1067 11.8333ZM9.6667 9.16663H6.33337C6.06004 9.16663 5.83337 8.93996 5.83337 8.66663C5.83337 8.39329 6.06004 8.16663 6.33337 8.16663H9.6667C9.94004 8.16663 10.1667 8.39329 10.1667 8.66663C10.1667 8.93996 9.94004 9.16663 9.6667 9.16663Z"
                                                        fill="white"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
        {{ $payment_request->links() }}
    </main>
@endsection
@section('footer')

@endsection

