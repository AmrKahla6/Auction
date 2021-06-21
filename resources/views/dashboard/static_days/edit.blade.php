<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
   <div class="modal-header">
       <h5 class="modal-title" id="exampleModalLabel">تعديل تاريخ العطله</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
   @include('partials._errors')
   @include('partials._session')
   <div class="modal-body">
       <form action="days-of/update" method="post" autocomplete="off">
           @csrf
           @method('PUT')
           <div class="form-group">
               <input type="hidden" name="id" id="id" value="">
               <label for="recipient-name" class="col-form-label"> التاريخ:</label>
               <input class="form-control" name="days_of" id="days_of" type="date">
           </div>
   </div>
   <div class="modal-footer">
       <button type="submit" class="btn btn-primary">تاكيد</button>
       <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
   </div>
   </form>
</div>
</div>
</div>
