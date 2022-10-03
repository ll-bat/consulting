<button type="button" class="btn btn-primary d-none" id="doc-download-modal" data-toggle="modal"
        data-target="#doc-modal">
    Open modal
</button>

<div class='container mt-5'>
    <div class="modal fade" id="doc-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"> {{ __("გადმოწერეთ როგორც") }} </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div>
                        <a class='pointer link' id="doc-download-pdf">
                            <img src='/icons/pdf.png' class='p-2 hoverable' height='120'/>
                        </a>
                        <a class='pointer link' id="doc-download-excel">
                            <img src='/icons/excel.png' class='p-2 hoverable' height='120'/>
                        </a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-3 py-1" data-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

    $('#doc-download-pdf').on('click', (e) => {
        $('#doc-download-modal').trigger('download', 'pdf');
    });

    $('#doc-download-excel').on('click', (e) => {
        $('#doc-download-modal').trigger('download', 'excel');
    })

</script>
