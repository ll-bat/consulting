<div class='anim-half-width anim-margin'
     style='background-color:#673ab7;border-radius:0px;border-right:1px solid #673ab7;box-shadow:2px 2px 4px grey !important'>
    <div class='card shadow-none anim-half-width anim-margin' v-if='showDangers'
         style='border-radius:10px;!important;border-top-right-radius:100px;border-bottom-left-radius:25px;'>
        <div class='card-body ml-2 pl-2'>
            <p class='ns-font-family ns-dark-color p-3 pb-0' style='font-size:1.3rem;'> აირჩიეთ საფრთხე </p>
            <div class="form-group p-3" style='width:55%;' v-if='currentDangers.length > 0'>
                <label for="sel1">Select list:</label>
                <select-component title="ყველა საფრთხე"
                                  :data="dangerSelect"
                                  :set-default="true"
                                  select-event="selectDanger"
                                  id="danger-id"
                                  @select="filterControls"
                ></select-component>
            </div>
        </div>
    </div>
</div>
