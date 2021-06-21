<div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضف يوم العطله</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            <form action="{{route('dashboard.post-static-days-of')}}" method="post" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label> ادخل اليوم </label>
                    <select name="day" id="" class="form-control">
                        <option value="" selected disabled>اختر العطله</option>
                        <option value="Saturday">السبت</option>
                        <option value="Sunday">الاحد</option>
                        <option value="Monday">الاثنين</option>
                        <option value="Tuesday">الثلاثاء</option>
                        <option value="Wednesday">الاربعاء</option>
                        <option value="Thursday">الخميس</option>
                        <option value="Friday">الجمعه</option>
                    </select>
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
