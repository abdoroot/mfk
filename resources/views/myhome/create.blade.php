<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-3">
                            <h5 class="font-weight-bold">{{ $pageTitle ?? trans('messages.list') }}</h5>
                            @if($auth_user->can('category list'))
                            <a href="{{ route('my-home.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('messages.back') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if(!is_null($data->id))
                          {{ Form::model($data,['method' => 'PUT','route'=> ['my-home.update',$data->id], 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'myhome'] ) }}
                        @else
                          {{ Form::model($data,['method' => 'POST','route'=>'my-home.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'myhome'] ) }}
                        @endif
                        {{ Form::hidden('id') }}
                        <div class="row">
                    
                            <div class="form-group col-md-4">
                                {{ Form::label('name_ar', __('messages.tenant_name_in_arabic').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('name[ar]', $data->getTranslation('name', 'ar'), ['placeholder' => __('messages.name_in_arabic'), 'class' => 'form-control', 'required', 'title' => __('validation.alpha_spaces')]) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            
                            <div class="form-group col-md-4">
                                {{ Form::label('name_en', __('messages.tenant_name_in_english').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('name[en]', $data->getTranslation('name', 'en'), ['placeholder' => __('messages.name_in_english'), 'class' => 'form-control', 'required', 'title' => __('validation.alpha_spaces')]) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('email', __('messages.email').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('email', $data->email, ['placeholder' => __('messages.email'), 'class' => 'form-control', 'required', 'title' => __('validation.alpha_spaces')]) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('contact_number',__('messages.contact_number').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                {{ Form::text('phone',$data->email ?? old('phone'),['placeholder' => __('messages.contact_number'),'class' =>'form-control contact_number','required']) }}
                                <small class="help-block with-errors text-danger" id="contact_number_err"></small>
                            </div>

                            <div class="form-group col-md-4">
                                {{ Form::label('status',trans('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                {{ Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'id' => 'role' ,'class' =>'form-control select2js','required']) }}
                            </div>
                            <div class="form-group col-md-4"></div>
                            <div class="form-group col-md-4">
                                {{ Form::label('start_date', __('messages.start_date').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::date('start_date', $data->start_date ?? now(), ['class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('end_date', __('messages.end_date').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::date('end_date', $data->end_date ?? null, ['class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('address_ar', __('messages.address_in_arabic').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('address[ar]', $data->getTranslation('address', 'ar'), ['placeholder' => __('messages.address_in_arabic'), 'class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('address_en', __('messages.address_in_english').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('address[en]', $data->getTranslation('address', 'en'), ['placeholder' => __('messages.address_in_english'), 'class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('building_no', __('messages.building_no').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('building_no', $data->building_no ?? null, ['placeholder' => __('messages.building_no'), 'class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('flat_no', __('messages.flat_no').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('flat_no', $data->flat_no ?? null, ['placeholder' => __('messages.flat_no'), 'class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('maintenance_borne', __('messages.maintenance_borne').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::select('maintenance_borne', ['owner' => __('messages.owner'), 'tenant' => __('messages.tenant')], $data->maintenance_borne ?? null, ['class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('borne_type', __('messages.borne_type').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::select('borne_type', ['amount' => __('messages.amount'), 'percentage' => __('messages.percentage')], $data->borne_type ?? null, ['class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('borne_amount', __('messages.borne_amount').' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                {{ Form::text('borne_amount', $data->borne_amount ?? null, ['placeholder' => __('messages.borne_amount'), 'class' => 'form-control', 'required']) }}
                                <small class="help-block with-errors text-danger"></small>
                            </div>
                            
                        </div>
                    
                        {{ Form::submit( trans('messages.save'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function preview() {
            category_image_preview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</x-master-layout>