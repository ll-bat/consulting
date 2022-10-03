<button type="button" class="btn btn-primary d-none" id='forms-modal' data-toggle="modal" data-target="#myModal">
    Open modal
</button>

 <div class='container mt-5'>
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title"> {{ __("აირჩიეთ დოკუმენტი") }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
          {{ __("გთხოვთ აირჩიოთ მინ.1 გადმოსაწერი დოკუმენტი") }}
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-danger border-0" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
</div>