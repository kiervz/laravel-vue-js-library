<template>
    <div class="container-fluid">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" 
                    id="book-inventory-tab" 
                    data-toggle="tab" 
                    href="#book-inventory" 
                    role="tab" 
                    aria-controls="book-inventory" 
                    aria-selected="true">
                    Book Inventory
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-borrowed-tab" 
                    data-toggle="tab" 
                    href="#book-borrowed" 
                    role="tab" 
                    aria-controls="book-borrowed" 
                    aria-selected="false">
                    Book Borrowed
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-returned-tab" 
                    data-toggle="tab" 
                    href="#book-returned" 
                    role="tab" 
                    aria-controls="book-returned" 
                    aria-selected="false">
                    Book Returned
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-lost-tab" 
                    data-toggle="tab" 
                    href="#book-lost" 
                    role="tab" 
                    aria-controls="book-lost" 
                    aria-selected="false">
                    Book Lost
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" 
                    id="book-overdue-tab" 
                    data-toggle="tab" 
                    href="#book-overdue" 
                    role="tab" 
                    aria-controls="book-overdue" 
                    aria-selected="false">
                    Book Overdue
                </a>
            </li>
        </ul>
        <!-- TAB CONTENT -->
        <div class="tab-content">
            <div class="tab-pane fade show active" 
                id="book-inventory" 
                role="tabpanel" 
                aria-labelledby="book-inventory-tab">
                <book-inventory></book-inventory>
            </div>
            <div class="tab-pane fade" 
                id="book-borrowed" 
                role="tabpanel" 
                aria-labelledby="book-borrowed-tab">
                <book-borrowed></book-borrowed>
            </div>
            <div class="tab-pane fade" 
                id="book-returned" 
                role="tabpanel" 
                aria-labelledby="book-returned-tab">
                <book-returned></book-returned>
            </div>
            <div class="tab-pane fade" 
                id="book-lost" 
                role="tabpanel" 
                aria-labelledby="book-lost-tab">
                <book-lost></book-lost>
            </div>
            <div class="tab-pane fade" 
                id="book-overdue" 
                role="tabpanel" 
                aria-labelledby="book-overdue-tab">
                <book-overdue></book-overdue>
            </div>
        </div>
    </div>
</template>

<script>
    import BookOverdue from './BookOverdue.vue'
    import BookLost from './BookLost.vue'
    import BookReturned from './BookReturned.vue'
    import BookBorrowed from './BookBorrowed.vue'
    import BookInventory from './BookInventory.vue'

    export default {
        components: { BookOverdue, BookLost, BookReturned, BookBorrowed, BookInventory },
        data() {
            return {
            }
        },
    }
</script>