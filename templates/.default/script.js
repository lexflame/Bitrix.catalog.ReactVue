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

new Vue({
    el: '#catalog-app',
    data: {
        filters: [],
        items: [],
        selectedFilters: {},
        page: 1,
        totalPages: 1,
        sortBy: 'NAME',
        sortOrder: 'ASC',
        loading: false
    },
    methods: {
        loadItems(reset = false) {
            if (this.loading || (this.page > this.totalPages && !reset)) return;

            this.loading = true;

            $.get('/local/components/custom/catalog.vueajax/ajax/filter.php', {
                ajax_filter: 'Y',
                filter: JSON.stringify(this.selectedFilters),
                page: this.page,
                sort_by: this.sortBy,
                order: this.sortOrder
            }, (res) => {
                if (reset) this.items = res.items;
                else this.items.push(...res.items);
                this.totalPages = res.totalPages;
                this.loading = false;
                this.page++;
            }, 'json');
        },
        onFilterUpdate(filters) {
            this.selectedFilters = filters;
            this.page = 1;
            this.loadItems(true); // reset items
        },
        changeSort(field) {
            if (this.sortBy === field) {
                this.sortOrder = this.sortOrder === 'ASC' ? 'DESC' : 'ASC';
            } else {
                this.sortBy = field;
                this.sortOrder = 'ASC';
            }
            this.page = 1;
            this.loadItems(true);
        },
        observeScroll() {
            const target = this.$refs.infiniteScroll;
            const observer = new IntersectionObserver(entries => {
                if (entries[0].isIntersecting) {
                    this.loadItems();
                }
            }, {
                rootMargin: '200px'
            });
            observer.observe(target);
        },
        updateUrl() {
            const params = new URLSearchParams();
            params.set('filter', JSON.stringify(this.selectedFilters));
            params.set('sort_by', this.sortBy);
            params.set('order', this.sortOrder);
            window.history.pushState({}, '', '?' + params.toString());
        },
        loadFromUrl() {
            const params = new URLSearchParams(window.location.search);
            const filter = params.get('filter');
            const sortBy = params.get('sort_by');
            const order = params.get('order');

            if (filter) this.selectedFilters = JSON.parse(filter);
            if (sortBy) this.sortBy = sortBy;
            if (order) this.sortOrder = order;
        }
    },
    mounted() {
        this.loadFromUrl();

        // init filters
        $.get('/local/components/custom/catalog.vueajax/ajax/filter.php', {
            get_filters: 'Y'
        }, (data) => {
            this.filters = data.filters;
        }, 'json');

        this.loadItems(true);
        this.observeScroll();
    }
});
