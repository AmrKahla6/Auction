<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضف قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            <form action="{{route('dashboard.post-days-of')}}" method="post" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label> ادخل التاريخ </label>
                    <input type="date" name="days_of" placeholder=" أضف تاريخ العطله" class="form-control" value="{{ old('days_of') }}" >
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit" id="Addsection"> حفظ البيانات </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
