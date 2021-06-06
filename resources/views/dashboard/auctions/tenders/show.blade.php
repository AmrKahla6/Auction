
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 10px;">المزايدات
                {{-- <small>{{ $tenders->total() }}</small> --}}
            </h3>
        </div>
        <div class="box-body">
            @if($tenders->count() > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>الاسم</th>
                        <th>عنوان المزاد</th>
                        <th>الحاله</th>
                        <th>@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($tenders as $index => $tender)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $tender->member->email }}</td>
                            <td>{{ $tender->auction->auction_title }}</td>
                            @if ($tender->is_winner == 0)
                                <td>مستمر</td>
                            @else
                                <td>فائز</td>
                            @endif
                            <td>
                                <form method="post"
                                    action="{{route('dashboard.auction.tenders-delete' , ['auction'=>$tender->auction->id,'tender'=>$tender->id])}}"
                                    style="display: inline-block">
                                    @csrf()
                                    @method('delete')
                                    @if(auth()->user()->hasPermission('delete_cities'))
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                    @else
                                        <button class="btn btn-danger btn-sm delete" disabled><i class="fa fa-trash"></i>@lang('site.delete')</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                {{ $tenders->appends(request()->query())->links() }}

            @else
                <h2>@lang('site.no_data_found')</h2>
            @endif

        </div>
    </div>

</section><!-- end of content -->
