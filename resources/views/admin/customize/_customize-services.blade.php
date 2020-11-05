







@include('admin.customize._tool-box', [
                    'items' => $data->texts->pageElements('services'),
                    'page' => 'services' 
])


<div id='app' class='mx-0'>
      <services></services>
</div>




<script src='/js/services.js' type='application/javascript'></script>