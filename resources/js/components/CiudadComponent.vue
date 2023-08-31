<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Ciudades Disponibles <span class="float-end"><button  @click="modificar=false; abrirModal();" type="button" class="btn btn-primary">Nueva Ciudad</button></span>
                    </div>
                    <div class="container">
                        <div class="row mt-3">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="filterName">Filtrar por Nombre</label>
                                    <input v-model="filterByName" type="text" id="filterName" class="form-control">
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="filterCountry">Filtrar por País</label>
                                    <input v-model="filterByCountry" type="text" id="filterCountry" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ciudad</th>
                                    <th scope="col">Pais</th>
                                    <th scope="col">Población</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ciud in applyFilters()" :key="ciud.id">
                                        <th scope="row">{{ciud.id}}</th>
                                        <td>{{ciud.name}}</td>
                                        <td>{{ciud.country}}</td>
                                        <td title="Personas">{{ciud.population}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a @click="modificar=true; abrirModal(ciud);"  class="btn btn-warning">Editar</a>
                                                <button  @click="eliminar(ciud.id)" class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal" :class="{mostrar:modal}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{titulomodal}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" @click="cerrarModal();">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name">Ciudad</label>
                                        <input v-model="ciudad.name" type="text" id="name" placeholder="Escriba la Ciudad" class="form-control">
                                        <span class="text-danger" v-if="errores.name">{{errores.name[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Pais</label>
                                        <input v-model="ciudad.country" type="text" id="country" placeholder="Escriba el Pais" class="form-control">
                                        <span class="text-danger" v-if="errores.country">{{errores.country[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="population">Población</label>
                                        <input v-model="ciudad.population" type="number" id="population" placeholder="Escriba la Población" class="form-control">
                                        <span class="text-danger" v-if="errores.population">{{errores.population[0]}}</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="cerrarModal();" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button  @click="guardar();"  type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2';
export default {
    data(){
        return{
            ciudads:[],
            titulomodal:'',
            modal:0,
            modificar:true,
            ciudad:{
                name:'',
                country:'',
                population:'',
            },
            id:0,
            errores:{},
            filterByName: '',
            filterByCountry: '',
        }
    },
    methods:{
        async listar(){
            const res= await axios.get('/ciudads');
            this.ciudads=res.data;
        },
        applyFilters() {
            return this.ciudads.filter(ciudad => {
                const nameMatch = ciudad.name.toLowerCase().includes(this.filterByName.toLowerCase());
                const countryMatch = ciudad.country.toLowerCase().includes(this.filterByCountry.toLowerCase());
                return nameMatch && countryMatch;
            });
        },
        async eliminar(id) {
            try {
                const res = await axios.delete('/ciudads/' + id);
                this.listar();
                await Swal.fire({
                    icon: 'success',
                    title: 'Ciudad eliminada',
                    text: 'La ciudad ha sido eliminada correctamente.',
                });
            } catch (error) {
                console.error('Error al eliminar:', error);
                await Swal.fire({
                    icon: 'error',
                    title: 'Error al eliminar',
                    text: 'Ocurrió un error al intentar eliminar la ciudad.',
                });
            }
        },
        async guardar(){
            try {
                if(this.modificar){
                    const res= await axios.put('/ciudads/'+this.id,this.ciudad);
                }else{
                    const res= await axios.post('/ciudads',this.ciudad);
                }
                this.cerrarModal();
                this.listar();
                await Swal.fire({
                    icon: 'success',
                    title: 'Ciudad guardada',
                    text: 'La ciudad ha sido guardada correctamente.',
                });
            }catch (error){
                if(error.response.data){
                    this.errores=error.response.data.errors
                }
                await Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: 'Ocurrió un error al intentar guardar la ciudad.',
                });
            }
        },
        abrirModal(data={}){
            this.modal=1;
            if(this.modificar){
                this.id=data.id;
                this.titulomodal="Editar Ciudad";
                this.ciudad.name=data.name;
                this.ciudad.country=data.country;
                this.ciudad.population=data.population;
            }else{
                this.id=0;
                this.titulomodal="Crear Ciudad";
                this.ciudad.name='';
                this.ciudad.country='';
                this.ciudad.population='';
            }
        },
        cerrarModal(){
            this.modal=0;
            this.errores={};
        },
    },
    created() {
        this.listar();
    },
}
</script>
<style>
.mostrar{
    display: list-item;
    opacity: 1;
    background: rgba(44,38,75,0.849);
}
</style>
