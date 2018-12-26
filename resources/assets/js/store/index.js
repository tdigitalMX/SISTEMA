import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        Interface: {
            Estatico: {
                MenuLateral: {



                }
            },
            Dinamico: {
                Componentes: {
                    Catalogo: {
                        Productos: {
                            Editar: {
                                EditarProducto: false,
                                InfoProducto: {}
                            },
                            ListaProductos: [],
                            ProductosCargados: false,
                            Paginador:1

                        }
                    }
                }
            }
        },
        Aplicacion:{
            Estado:{
                Conexion:true,
                ModoOffline:false
            }
        }
    }
});


