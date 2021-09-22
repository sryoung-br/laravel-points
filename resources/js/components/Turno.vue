<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
               <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Dia</th>
                        <th scope="col">1ª Ent</th>
                        <th scope="col">2ª Ent</th>
                        <th scope="col">1ª Sai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                    </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
