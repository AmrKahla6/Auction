<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضف رقم هاتف للشركه</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @include('partials._errors')
                @include('partials._session')
            <form action="{{route('dashboard.setting-store-phone')}}" method="post" autocomplete="off">
                @csrf
                <div class="form-group">
                    <input type="tel" name="number" class="form-control" id="number" placeholder="ادخل  الرقم">
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
