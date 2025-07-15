<? $this->SetViewTarget("vue_area"); ?>
    <div id="catalog-app" class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <catalog-filter :filters="filters" @update="onFilterUpdate"></catalog-filter>
                <div class="mt-4">
                    <h6>Сортировка</h6>
                    <button @click="changeSort('NAME')" class="btn btn-sm btn-outline-light">По имени</button>
                    <button @click="changeSort('SORT')" class="btn btn-sm btn-outline-light">По популярности</button>
                    <button @click="changeSort('CATALOG_PRICE_1')" class="btn btn-sm btn-outline-light">По цене</button>
                </div>
            </div>
            <div class="col-md-9">
                <catalog-list :items="items"></catalog-list>
                <div ref="infiniteScroll" class="text-center my-4">
                    <div v-if="loading">Загрузка...</div>
                    <div v-else-if="page > totalPages">Все товары загружены</div>
                </div>
            </div>
        </div>
    </div>
<? $this->EndViewTarget(); ?>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>