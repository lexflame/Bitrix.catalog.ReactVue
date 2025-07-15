Vue.component('catalog-filter', {
    props: ['filters'],
    template: `<div>
        <h5>Фильтр</h5>
        <div v-for="filter in filters" :key="filter.id">
            <input type="checkbox" :value="filter.value" @change="$emit('update', filter)">
            {{ filter.name }}
        </div>
    </div>`
});

Vue.component('catalog-list', {
    props: ['items'],
    template: `<div class="row">
        <div class="col-md-4 mb-4" v-for="item in items" :key="item.ID">
            <div class="card h-100">
                <img class="card-img-top" :src="item.PICTURE_SRC" alt="">
                <div class="card-body">
                    <h5 class="card-title">{{ item.NAME }}</h5>
                    <p class="card-text">{{ item.PREVIEW_TEXT }}</p>
                </div>
            </div>
        </div>
    </div>`
});

new Vue({
    el: '#catalog-app',
    data: {
        filters: [], // Получать через AJAX при инициализации
        items: <?= CUtil::PhpToJSObject($arResult['ITEMS']) ?>
    },
    methods: {
        onFilterUpdate(filter) {
            $.get('/local/components/custom/catalog.vueajax/ajax/filter.php', {
                ajax_filter: 'Y',
                filter: JSON.stringify(filter)
            }, (response) => {
                this.items = response.items;
            }, 'json');
        }
    },
    mounted() {
        // Инициализировать фильтры
        $.get('/local/components/custom/catalog.vueajax/ajax/filter.php', {
            get_filters: 'Y'
        }, (data) => {
            this.filters = data.filters;
        }, 'json');
    }
});
