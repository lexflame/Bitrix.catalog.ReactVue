Inst component to page

$APPLICATION->ShowViewContent("vue_area");


🛍️ Bitrix D7 Vue.js Catalog Component (AJAX + Responsive + Smart Filters)
This is a highly optimized AJAX-based product catalog component for Bitrix D7, designed for modern eCommerce projects. It leverages Vue.js, jQuery, and Bootstrap 4 to deliver a fast, interactive, and mobile-friendly user experience with composite site support.

🔧 Key Features
AJAX Filtering by Properties:
Filter products using smart checkboxes for custom properties (e.g., color, size), including integration with trade offers (SKU) via CML2_LINK.

Sorting Options:
Users can sort by:

Name (A–Z / Z–A)

Price (ascending/descending)

Popularity (based on the SORT field)

Pagination & Lazy Load:
Combines traditional server-side pagination (CIBlockElement::GetList) with infinite scrolling via IntersectionObserver.

URL Filter Sync:
Filter and sorting state is synchronized with the URL using history.pushState, allowing users to bookmark or share exact catalog states.

Session Storage Support:
Selected filters are stored in sessionStorage to persist state during navigation or page refresh.

Responsive Layout (Bootstrap 4):
Mobile-first grid layout using Bootstrap 4 ensures seamless UX across all devices.

D7 Core & Clean Output:
AJAX responses are handled using Bitrix D7 core classes (Application::getInstance()->getContext()->getResponse()), ensuring clean and standard-compliant JSON output.

High Performance:
Fully compatible with Bitrix composite mode, supporting both managed and unmanaged caching where applicable.

📁 Technologies Used
Bitrix D7 (Modules: iblock, catalog)

Vue.js (Reactive frontend)

jQuery (AJAX layer & legacy compatibility)

Bootstrap 4 (Responsive layout)

IntersectionObserver (native JS lazy loading)

LocalStorage / SessionStorage

URLSearchParams / history API

✅ Suitable For
eCommerce product catalogs

Filter-heavy listings

SPA-like interactions in Bitrix

Composite/Highload websites needing performance and interactivity
