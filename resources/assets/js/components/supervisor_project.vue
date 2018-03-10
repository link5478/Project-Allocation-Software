<template>
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Example Component</div>

                <div class="panel-body">
                    <p>Name: {{name}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props:['name'],


        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
