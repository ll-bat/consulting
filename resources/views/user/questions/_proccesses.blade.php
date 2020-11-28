
 <div class='text-left d-none' id='show_data'>
     <div class='card rounded-10 shadow-none animate-process' id='edit-process' style='border-bottom-left-radius: 0; border-bottom-right-radius: 0;'>
         <div class='card-body ml-2 pl-2'>
             <p class= 'ns-font-family ns-dark-color py-2 px-2' style='font-size:1.3rem;'> აირჩიეთ პროცესი </p>
             <div class="form-group" style='width:50%;'>
                <label for="sel1">Select list:</label>
{{--                <select class="form-control py-2 px-2" @change="choose()" id="sel1" style='line-height:2rem;'>--}}
{{--                    <option class="p-5" selected disabled style='font-size:1.1rem !important'>ყველა პროცესი</option>--}}
{{--                       <option class='p-5' v-for='p in process' style='font-size:1.1rem !important;font-weight:400;' :value='p.id'>--}}
{{--                           <span style="max-width: 400px; line-break: anywhere">@{{p.name}} </span>--}}
{{--                       </option>--}}
{{--                </select>--}}
                    <select-component title="ყველა პროცესი" :data="allProcess" @select="choose"> </select-component>
           </div>
      </div>
</div>
