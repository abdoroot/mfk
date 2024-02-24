{{ Form::hidden('id',$orderdata->id) }}

<div class="card-body p-0">
    <div class="border-bottom pb-3 d-flex justify-content-between align-items-center gap-3 flex-wrap">
        <div>
            <h3 class="c1 mb-2">{{__('messages.order_id')}} {{ '#' . $orderdata->id ?? '-'}}</h3>
            <p class="opacity-75 fz-12">
                {{__('messages.order_placed')}} {{ $orderdata->created_at ?? '-'}}
            </p>
        </div>
        <div class="d-flex flex-wrap flex-xxl-nowrap gap-3" data-select2-id="select2-data-8-5c7s">
        <div class="w3-third">
                 <a href="{{ route('store-order.change_order_status_form',['id'=> $orderdata->id ]) }}"
                 class="float-right btn btn-sm btn-primary loadRemoteModel"><i class="lab la-telegram-plane"></i>
                 {{ __('messages.change_status') }}</a>
                   
            </div>
            @if($orderdata->payment_id !== null)
            <a href="{{route('invoice_pdf',$orderdata->id)}}" class="btn btn-primary" target="_blank">
                <i class="ri-file-text-line"></i>

                {{__('messages.invoice')}}
            </a>
            @endif
        </div>
        </div>
    </div>

    <div class="pay-box">
        <div class="pay-method-details">
            <h4 class="mb-2">{{__('messages.payment_method')}}</h4>
            <h5 class="c1 mb-2">{{__('messages.cash_after')}}</h5>
            <p><span>{{__('messages.amount')}} :
                </span><strong>{{!empty($orderdata->total_amount) ? getPriceFormat($orderdata->total_amount): 0}}</strong>
            </p>
        </div>
        <div class="pay-booking-details">
            <div class="row mb-2">
                <div class="col-sm-6"><span>{{__('messages.order_status')}} :</span></div>
                <div class="col-sm-6 align-text">
                    <span class="c1" id="booking_status__span">{{  App\Models\BookingStatus::bookingStatus($orderdata->status)}}</span>      
                </div>
                @if($orderdata->status === "cancelled")
                    <div class="col-sm-6"><span>{{__('messages.reason')}} :</span></div>
                     <div class="col-sm-6 align-text">
                        <span class="c1" id="booking_status__span">{{ $orderdata->reason }}</span>
                    </div>
                @endif
            </div>
            <div class="row mb-2">
                <div class="col-sm-6"> <span>{{__('messages.payment_status')}} : </span></div>
                <div class="col-sm-6 align-text">
                    <span id="payment_status__span"
                        class="{{ optional($orderdata->payment)->payment_status == 'paid' ? 'text-success' : 'text-danger' }}">
                        {{ ucwords(str_replace('_', ' ',  optional($orderdata->payment)->payment_status ?: 'pending'))}}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h5>
                        {{__('messages.order_date')}} :
                    </h5>
                </div>
                <div class="col-sm-6 align-text">
                    <span id="service_schedule__span">{{ $orderdata->created_at ?? '-'}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 d-flex gap-3 flex-wrap customer-info-detail mb-2">
        <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
            <h4 class="mb-2">{{__('messages.customer_information')}}</h4>
            <h5 class="c1 mb-3">{{optional($orderdata->customer)->display_name ?? '-'}}</h5>
            <ul class="list-info">
                <li>
                    <span class="material-icons customer-info-text">{{__('messages.phone_information')}}</span>
                    <a href="" class="customer-info-value">
                        <p class="mb-0">{{ optional($orderdata->customer)->contact_number ?? '-' }}</p>
                    </a>
                </li>
                <li>
                    <span class="material-icons  customer-info-text">{{__('messages.shipping_address')}}</span>
                    <p class="customer-info-text">{{ $orderdata->shipping_address ?? '-' }}</p>
                </li>
            </ul>
        </div>

        <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
            <h4 class="mb-2">{{__('messages.provider_information')}}</h4>
            <h5 class="c1 mb-3">{{optional($orderdata->provider)->display_name ?? '-'}}</h5>
            <ul class="list-info">
                <li>
                    <span class="material-icons customer-info-text">{{__('messages.phone_information')}}</span>
                    <a href="" class="customer-info-value">
                        <p class="mb-0">{{ optional($orderdata->provider)->contact_number ?? '-' }}</p>
                    </a>
                </li>
                <li>
                    <span class="material-icons customer-info-text">{{__('messages.address')}}</span>
                    <p class="customer-info-text">{{ optional($orderdata->provider)->address ?? '-' }}</p>
                </li>
            </ul>
        </div>
    </div>

    @php
        $addonTotalPrice = 0;
    @endphp

    <h3 class="mb-3 mt-3">{{__('messages.order_summery')}}</h3>
    <div class="table-responsive border-bottom">
        <table class="table text-nowrap align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-lg-3">{{__('messages.item')}}</th>
                    <th>{{__('messages.price')}}</th>
                    <th>{{__('messages.quantity')}}</th>
                    <th class="text-end">{{__('messages.sub_total')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderdata->formatted_items as $item)
                <tr>
                    <td class="text-wrap ps-lg-3">
                        <div class="d-flex flex-column">
                            <a href="{{route('store-item.create',['id' =>$item['id']])}}" class="booking-service-link fw-bold">{{$item['name'] ?? '-'}}</a>
                        </div>
                    </td>
                    <td>{{ isset($item['amount']) ? getPriceFormat($item['amount']) : 0 }}</td>
                    <td>{{!empty($item['quantity']) ? $item['quantity'] : 0}}</td>
                    <td class="text-end">{{!empty($item['price']) ? $item['price'] : 0}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row justify-content-end mt-3">
        <div class="col-sm-10 col-md-6 col-xl-5">
            <div class="table-responsive bk-summary-table">
                <table class="table-sm title-color align-right w-100">
                    <tbody>
                        <tr>
                            <td>{{__('messages.price')}}</td>
                            <td class="bk-value">
                                --
                            </td>
                        </tr>
                        @if($orderdata->bookingPackage == null)
                        <tr>
                            <td>{{__('messages.discount')}} ({{$orderdata->discount}}% off)</td>
                            <td class="bk-value text-success">-{{getPriceFormat($orderdata->discount)}}</td>
                        </tr>
                        @endif
                        @if($orderdata->couponAdded != null)
                        <tr>
                            <td>{{__('messages.coupon')}} ({{($orderdata->couponAdded->code)}})</td>
                            <td class="bk-value text-success">-{{ getPriceFormat($orderdata->discount) }}</td>
                            <td class="bk-value text-success">-{{ getPriceFormat($orderdata->discount) }}</td>
                        </tr>
                        @endif
                        <tr class="grand-sub-total">
                            <td>{{__('messages.subtotal_vat')}}</td>
                            <td class="bk-value">{{getPriceFormat($orderdata->amount)}}</td>
                        </tr>
                    
                        <tr>
                            <td>{{__('messages.tax')}}</td>
                            <td class="text-right text-danger">{{getPriceFormat($orderdata->tax)}}</td>
                        </tr>
                     
                      
                        <tr class="grand-total">
                            <td><strong>{{__('messages.grand_total')}}</strong></td>
                            <td class="bk-value">
                                <h3>{{getPriceFormat($orderdata->total_amount)}}</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>
$(document).on('change', '.bookingstatus', function() {

    var status = $(this).val();

    var id = $(this).attr('data-id');
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('bookingStatus.update') }}",
        data: {
            'status': status,
            'bookingId': id
        },
        success: function(data) {}
    });
})

$(document).on('change', '.paymentStatus', function() {

    var status = $(this).val();

    var id = $(this).attr('data-id');
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{ route('bookingStatus.update') }}",
        data: {
            'status': status,
            'bookingId': id
        },
        success: function(data) {}
    });
})
</script>