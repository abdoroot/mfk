<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">{{ $pageTitle ?? trans('messages.list') }}</h5>
                            <a href="{{ route('user-subscriptions-plan.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('messages.back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($plan,['method' => 'POST','route'=>'user-subscriptions-plan.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'plan'] ) }}
                        {{ Form::hidden('id') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('title',trans('messages.title_in_arabic').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::text('title[ar]',$plan->getTranslation('title', 'ar') ?? old('title[ar]'),['placeholder' => trans('messages.title_in_arabic'),'class' =>'form-control','required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('title',trans('messages.title_in_english').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::text('title[en]',$plan->getTranslation('title', 'en') ?? old('title[en]'), ['placeholder' => trans('messages.title_in_english'), 'class' =>'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('name', __('messages.select_name',[ 'select' => __('messages.category') ]).' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('category_id', [optional($plan->category)->id => optional($plan->category)->name], optional($plan->category)->id, [
                                            'class' => 'select2js form-group category',
                                            'required',
                                            'id' => 'category_id',
                                            'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.category') ]),
                                            'data-ajax--url' => route('ajax-list', ['type' => 'category']),
                                        ]) }}

                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('subcategory_id', __('messages.select_name',[ 'select' => __('messages.subcategory') ]),['class'=>'form-control-label'],false) }}
                                <br />
                                {{ Form::select('subcategory_id', [], [
                                        'class' => 'select2js form-group subcategory_id',
                                        'data-placeholder' => __('messages.select_name',[ 'select' => __('messages.subcategory') ]),
                                    ]) }}
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('type',trans('messages.type').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('type', [
    'monthly' => __('messages.monthly'),
    '3_months' => __('messages.3_months'),
    '6_months' => __('messages.6_months'),
    'yearly' => __('messages.yearly')
], old('type'), ['id' => 'type', 'class' =>'form-control select2js', 'required']) }}
                            </div>
                            <!-- <div class="form-group col-md-4">
                                    {{ Form::label('duration',trans('messages.duration').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                    {{ Form::select('duration',['1' => '1' , '2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12' ],old('duration'),[ 'id' => 'duration' ,'class' =>'form-control select2js','required']) }}
                                </div> -->
                            <div class="form-group col-md-4">
                                {{ Form::label('amount',__('messages.amount').' <span class="text-danger">*</span>', ['class' => 'form-control-label'],false) }}
                                {{ Form::number('amount',old('amount'),['placeholder' => __('messages.amount'),'class' =>'form-control', 'required', 'step' => 'any', 'min' => 0]) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('status',trans('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'id' => 'role' ,'class' =>'form-control select2js','required']) }}
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 ">
                                {{ Form::label('description',__('messages.description_in_arabic'), ['class' => 'form-control-label']) }}
                                {{ Form::textarea('description[ar]', $plan->getTranslation('description', 'ar') ?? old('description[ar]'), ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('messages.description') ]) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 ">
                                {{ Form::label('description',__('messages.description_in_english'), ['class' => 'form-control-label']) }}
                                {{ Form::textarea('description[en]', $plan->getTranslation('description', 'en') ?? old('description[en]'), ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('messages.description') ]) }}
                            </div>
                        </div>

                        {{ Form::submit( trans('messages.save'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('bottom_script')
    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
            var category_id = "{{ isset($plan->category_id) ? $plan->category_id : '' }}";
            var subcategory_id = "{{ isset($plan->subcategory_id) ? $plan->subcategory_id : '' }}";
            getSubCategory(category_id, subcategory_id)


            $(document).on('change', '#category_id', function() {
                var category_id = $(this).val();
                $('#subcategory_id').empty();
                getSubCategory(category_id, subcategory_id);
            })
              

             function getSubCategory(category_id, subcategory_id = "") {
            console.log('s');
            var get_subcategory_list =
                "{{ route('ajax-list', [ 'type' => 'subcategory_list','category_id' =>'']) }}" + category_id;
            get_subcategory_list = get_subcategory_list.replace('amp;', '');

            $.ajax({
                url: get_subcategory_list,
                success: function(result) {
                    $('#subcategory_id').select2({
                        width: '100%',
                        placeholder: "{{ trans('messages.select_name',['select' => trans('messages.subcategory')]) }}",
                        data: result.results
                    });
                    if (subcategory_id != "") {
                        $('#subcategory_id').val(subcategory_id).trigger('change');
                    }
                }
            });
        }
            });
        })(jQuery);
    </script>
    @endsection
</x-master-layout>