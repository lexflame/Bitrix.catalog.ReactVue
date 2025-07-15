<? $this->SetViewTarget("vue_area"); ?>
    <div id="catalog-app" class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <catalog-filter :filters="filters" @update="onFilterUpdate"></catalog-filter>
            </div>
            <div class="col-md-9">
                <catalog-list :items="items"></catalog-list>
            </div>
        </div>
    </div>
<? $this->EndViewTarget(); ?>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>