





 

@foreach ($items as $id => $obj)
           @include('admin.customize._box', ['obj' => $obj, 
                                             'page' => $page,  
                                             'element' => $id, 
                                             'id' => $page.'-'.$id
            ])

@endforeach


<script type='application/javascript'>
      app.create('{{$page}}', new Toolbox({!! json_encode($items) !!}))
</script>
