import MainLayout from "@/pages/Dashboard/Layout/DashboardLayout.vue";

import store from '@/store';



import Escritorio from '@/AppComponentes/Dashboard/Escritorio.vue'
 //
import AccesoUsuarios from '@/AppComponentes/Dashboard/Accesos/Usuarios.vue'
import AccesoRoles from '@/AppComponentes/Dashboard/Accesos/Roles.vue'
//
import AtencionGeneralRecetasElectronicas from '@/AppComponentes/Dashboard/AtencionGeneral/RecetasElectronicas.vue'
import AtencionGeneralRecetasCertificados from '@/AppComponentes/Dashboard/AtencionGeneral/Certificados.vue'
import AtencionGeneralRecetasPacientes from '@/AppComponentes/Dashboard/AtencionGeneral/Pacientes.vue'
//
import CatalogoCategorias from '@/AppComponentes/Dashboard/Catalogos/Categorias.vue'
import CatalogoProductos from '@/AppComponentes/Dashboard/Catalogos/Productos.vue'
import CatalogoImportarProductos from '@/AppComponentes/Dashboard/Catalogos/ImportarProducto.vue'

import CatalogoFormularioAgregarProductos from '@/AppComponentes/Dashboard/Catalogos/FormAgregarProducto.vue'
import CatalogoFormularioClasificacionGrupos from '@/AppComponentes/Dashboard/Catalogos/Clasificacion/FormGrupo.vue'

import CatalogoClasificacionGrupo from '@/AppComponentes/Dashboard/Catalogos/Clasificacion/Grupo.vue'
import CatalogoClasificacionCuadroBasico from '@/AppComponentes/Dashboard/Catalogos/Clasificacion/CuadroBasico.vue'
//
import ReportesUsuarios from '@/AppComponentes/Dashboard/Reportes/Usuarios.vue'
import ReportesPacientes from '@/AppComponentes/Dashboard/Reportes/Pacientes.vue'
//
import Ayuda from '@/AppComponentes/Dashboard/Ayuda.vue'
import AcercaDe from '@/AppComponentes/Dashboard/AcercaDe.vue'



let componentesAcceso = {
  path: "/acceso",
  component: MainLayout,
  name: "Acceso",
  redirect: "/acceso/usuarios",
  children: [
    {
      path: "usuarios",
      name: "Usuarios",
      components: { default: AccesoUsuarios }
    },
    {
      path: "roles",
      name: "Roles",
      components: { default: AccesoRoles }
    },
  ]
};


let componentesAtencionGeneral = {
  path: "/atencion-general",
  component: MainLayout,
  name: "Atencion General",
  redirect: "/atencion-general/recetas-electronicas",
  children: [
    {
      path: "recetas-electronicas",
      name: "Recetas Electronicas",
      components: { default: AtencionGeneralRecetasElectronicas }
    },
    {
      path: "certificados",
      name: "Certificados",
      components: { default: AtencionGeneralRecetasCertificados }
    },
    {
      path: "pacientes",
      name: "Pacientes",
      components: { default: AtencionGeneralRecetasPacientes }
    },
  ]
};



let componentesReportes = {
  path: "/reportes",
  component: MainLayout,
  name: "Reportes",
  redirect: "/reportes/pacientes",
  children: [
    {
      path: "pacientes",
      name: "Pacientes",
      components: { default: ReportesPacientes }
    },
    {
      path: "usuarios",
      name: "Usuarios",
      components: { default: ReportesUsuarios }
    }
  ]
};

let componentesCatalogo = {
  path: "/catalogo",
  component: MainLayout,
  name: "Reportes",
  redirect: "/catalogo/productos",
  children: [
    {
      path: "productos",
      name: "Productos",
      components: { default: CatalogoProductos }
    },
    {
      path: "categorias",
      name: "Categorias",
      components: { default: CatalogoCategorias }
    },
    {
      path: "form-producto",
      name: "Form Productos",
      components: { default: CatalogoFormularioAgregarProductos },
      meta: { scrollToTop: true }
    },
    {
      path: "importar-producto",
      name: "Productos / Importar",
      components: { default: CatalogoImportarProductos }
    },
    {
      path: "/catalogo/clasificacion", 
      name: "Clasificacion",
      redirect: "/catalogo/clasificacion/grupo",
      children: [
        
       
      ]
    },
    {
      path: "/catalogo/clasificacion/grupo",
      name: "Grupo",
      components: { default: CatalogoClasificacionGrupo }
    },
    {
      path: "/catalogo/clasificacion/cuadro-basico",
      name: "Cuadro Básico",
      components: { default: CatalogoClasificacionCuadroBasico }
    },
    {
      path: "/catalogo/clasificacion/form-grupos",
      name: "Clasificacion / Grupos",
      components: { default: CatalogoFormularioClasificacionGrupos }
    },
    
  ]
};





const routes = [

  {
    path: "/",
    redirect: "/escritorio",
    name: "Home"
  },
  componentesAcceso,
  componentesAtencionGeneral,
  componentesReportes,
  componentesCatalogo,
  {
    path: "/",
    component: MainLayout,
    children: [
      {
        path: "escritorio",
        name: "Escritorio",
        components: { default: Escritorio }
      },
      {
        path: "ayuda",
        name: "Ayuda",
        components: { default: Ayuda }
      },
      {
        path: "info-app",
        name: "Acerca de",
        components: { default: AcercaDe }
      },
    ]
  }


]



export default routes;
