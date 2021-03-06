@extends('layouts.login')

@section('title', 'Farmers Login')

@section('content')
    <div class="ibox-content">
        <div class="text-center">
            <img src="{{ URL::to('/images/logo.png') }}" alt="agrabah-logo" class="logo img-fluid mt-3" width="250">
        </div>
    </div>

    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>REFERENCE ID: <strong>{{ $trace->reference }}</strong></h2>
                    </div>
                    <div class="panel-body inspinia-timeline">
                        <div class="row">
                            <div class="col-sm-7">
{{--                                <div class="row">--}}

{{--                                    <div class="col-sm-12">--}}
{{--                                        <div class="panel panel-default">--}}
{{--                                            <div class="panel-heading">--}}
{{--                                                <h5>Dispatch <small>info</small></h5>--}}
{{--                                            </div>--}}
{{--                                            <div class="panel-body">--}}
{{--                                                <div class="mb-2">--}}
{{--                                                    <h3 class="mb-0">{{ $trace->dispatch->value_0 }}</h3>--}}
{{--                                                    <small class="text-success">Driver Name</small>--}}
{{--                                                </div>--}}
{{--                                                <div class="mb-2">--}}
{{--                                                    <h3 class="mb-0">{{ $trace->dispatch->value_1 }}</h3>--}}
{{--                                                    <small class="text-success">Mobile no.</small>--}}
{{--                                                </div>--}}
{{--                                                <div class="mb-2">--}}
{{--                                                    <h3 class="mb-0">{{ $trace->dispatch->value_2 }}</h3>--}}
{{--                                                    <small class="text-success">Vehicle Type</small>--}}
{{--                                                </div>--}}
{{--                                                <div class="mb-2">--}}
{{--                                                    <h3 class="mb-0">{{ $trace->dispatch->value_3 }}</h3>--}}
{{--                                                    <small class="text-success">Plate No.</small>--}}
{{--                                                </div>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h5>Inventory <small>Info</small></h5>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Detail</th>
                                                            <th class="text-right">Status</th>
                                                            <th class="text-right">Remark</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="item-list">
                                                        @foreach($trace->inventories as $data)
                                                            <tr>
                                                                <td>{{ $data->product->display_name }}</td>
                                                                <td>{{ $data->quality }}; {{ $data->quantity }} {{ $data->unit }}</td>
                                                                <td class="text-right">{{ $data->status }}</td>
                                                                <td class="text-right">
                                                                    @if( ($data->status == 'Delivered') && ($data->receiver_remark == null) )
                                                                        <textarea name="" class="form-control no-resize"></textarea>
                                                                        <button type="button" class="btn btn-success btn-block btn-action" data-action="submit-remark" data-id="{{ $data->id }}">Submit Remark</button>
                                                                    @else
                                                                        <p>{{ $data->receiver_remark }}</p>
                                                                    @endif

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
{{--                                                        <tfoot>--}}
{{--                                                        <tr>--}}
{{--                                                            <td colspan="4">--}}
{{--                                                                <button type="button" class="btn btn-success btn-block">Submit Remarks</button>--}}
{{--                                                            </td>--}}
{{--                                                        </tr>--}}
{{--                                                        </tfoot>--}}
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <h5>Timeline <small>info</small></h5>
                                @foreach($trace->timeline as $timeline)
                                    <div class="timeline-item">
                                        <div class="row">
                                            <div class="col-3 date">
                                                {{--                                        <i class="fa fa-file-text"></i>--}}
                                                {{ \Carbon\Carbon::parse($timeline->created_at)->toFormattedDateString() }}
                                                <br/>
                                                <small class="text-navy">{{ \Carbon\Carbon::parse($timeline->created_at)->diffForHumans(\Carbon\Carbon::now()) }}</small>
                                            </div>
                                            <div class="col-7 content">
                                                <p class="m-b-xs"><strong>{{ $timeline->value_0 }}</strong></p>
                                                <p>{{ $timeline->value_1 }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('styles')
    {{--{!! Html::style('') !!}--}}
@endsection

@section('scripts')
    {{--        {!! Html::script('') !!}--}}
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btn-action', function(){
                var container = $(this).closest('td');
                var id = $(this).data('id');
                var remark = $(this).closest('td').find('textarea').val();

                console.log(id);
                console.log(remark);

                $.get('{!! route('submit-remark') !!}', {
                    id: id,
                    remark: remark
                }, function(data){
                    if(data.receiver_remark !== null){
                        container.empty().append('<p>'+ data.receiver_remark +'</p>')
                    }
                });
            })
        });
    </script>
@endsection
