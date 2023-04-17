<template>
    <div v-if="data" class="pagination">
        <br>
            <template v-for="(link, key) in data.links" :key="key">
                <a class="page-link" v-if="link.label === 'pagination.previous'" @click="$emit('getPage', link.url)">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="page-link" v-if="link.label === 'pagination.next'" @click="$emit('getPage', link.url)">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                <a class="page-link" v-if="!isNaN(link.label) && link.url" @click="$emit('getPage', link.url)">{{link.label}}</a>
            </template>
    </div>
</template>
<script>
export default {
    props: {
        data: null
    },
}
</script>
<style>
.pagination {
    width: 70%;
margin: 0 auto;
}

.pagination a {
  color: black;
  display: inline-block;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>