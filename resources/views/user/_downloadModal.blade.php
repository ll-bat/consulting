<button type="button" class="btn btn-primary d-none" id="download-modal{{$buttonId}}" data-toggle="modal" data-target="#modal-{{$buttonId}}">
    Open modal
</button>

 <div class='container mt-5'>
  <div class="modal fade" id="modal-{{$buttonId}}">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title"> გადმოწერეთ როგორც </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div id = 'content-for-{{$id}}'>
                  <a href='/user/doc/{{$id}}/export?pdf=1' onclick="downloadFile({{$id}})" class='pointer link'>
                     <img src='/icons/pdf.png'   class='p-2 hoverable' height='120'/>
                  </a>
                  <a href='/user/doc/{{$id}}/export?excel=1' onclick="downloadFile({{$id}})" class='pointer link'>
                     <img src='/icons/excel.png' class='p-2 hoverable' height='120'/>
                  </a>
             </div>

             <div class='d-none mt-5 mx-1 mb-1' id='loading-{{$id}}'>
                  <div class="progress">
                      <div class="progress-bar progress-bar-striped progress-bar-animated"
                           style="width:100%"></div>
                  </div>
             </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger rounded-pill px-3 py-1" id='close-modal-{{$id}}' data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</div>
