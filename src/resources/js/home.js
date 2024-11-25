var triggerTabList = [].slice.call(document.querySelectorAll('#nav-tab button'))
triggerTabList.forEach(function (triggerEl) {
    var tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', function (event) {
        event.preventDefault()
        tabTrigger.show()
    })
})
const form = document.querySelector('form');
btnBuscar = document.querySelector("#btn-buscar");
btnBuscarSpin = document.querySelector("#btn-buscar-spin");
btnBuscarTxt = document.querySelector("#btn-buscar-txt");
resultados = document.querySelector("#resultados");

resultadosISSS = document.querySelector("#resultadosISSS");
resultadosContainerISSS = document.querySelector("#containerISSS");
resultadosBASE_TIGO = document.querySelector("#resultadosBASE_TIGO");
resultadosContainerBASE_TIGO = document.querySelector("#containerBASE_TIGO");
resultadosDUI = document.querySelector("#resultadosDUI");
resultadosContainerDUI = document.querySelector("#containerDUI");
resultadosNIT = document.querySelector("#resultadosNIT");
resultadosContainerNIT = document.querySelector("#containerNIT");
resultadosLICENCIA = document.querySelector("#resultadosLICENCIA");
resultadosContainerLICENCIA = document.querySelector("#containerLICENCIA");
resultadosVEHICULO = document.querySelector("#resultadosVEHICULO");
resultadosContainerVEHICULO = document.querySelector("#containerVEHICULO");

variables = "q=";
document.addEventListener('readystatechange', function (event) {
    if (document.readyState === "complete") {
        btnBuscar.addEventListener('click', () => {
            ejecutarBusqueda();
        })

    }
});
form.addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar que el formulario se envíe por defecto
    ejecutarBusqueda(); // Ejecutar la función de búsqueda
});

function ejecutarBusqueda() {
    resultadosISSS.setAttribute("aria-busy", "true");
    resultadosBASE_TIGO.setAttribute("aria-busy", "true");
    resultadosDUI.setAttribute("aria-busy", "true");
    resultadosNIT.setAttribute("aria-busy", "true");
    resultadosLICENCIA.setAttribute("aria-busy", "true");
    resultadosVEHICULO.setAttribute("aria-busy", "true");
    clearResults();
    buscarAction();

}

function expandirBusqueda(source, value) {
    document.querySelector("#q").value = value;
    ejecutarBusqueda();
}

function clearResults() {
    resultadosContainerISSS.innerHTML = "";
    resultadosContainerDUI.innerHTML = "";
    resultadosContainerBASE_TIGO.innerHTML = "";
    resultadosContainerNIT.innerHTML = "";
    resultadosContainerLICENCIA.innerHTML = "";
    resultadosContainerVEHICULO.innerHTML = "";
}

function buscarAction() {
    btnBuscarTxt.textContent = "Buscando...";
    btnBuscarSpin.classList.remove('d-none');
    q = document.querySelector("#q").value;
    variables = "q=" + q;
    POST_AJAX("/ajaxBuscar", variables + "&bd=ISSS&order=1", busquedaCompletadaISSS, true);
    /*let peticion2 = POST_AJAX("/ajaxBuscar", variables + "&bd=DUI&order=2", busquedaCompletadaDUI, true);
    let peticion3 = POST_AJAX("/ajaxBuscar", variables + "&bd=BASE_TIGO&order=3", busquedaCompletadaBASE_TIGO, true);
    $.when(peticion1, peticion2).then(peticion3);

    */
}

function busquedaCompletadaISSS() {
    if ((objeto.readyState == 4) && (objeto.status == 200)) {
        mia = objeto.responseText.split('^-^');
        if (mia[0] == "yes") {
            resultados.classList.remove('d-none');
            var triggerEl = document.querySelector('#nav-isss-tab')
            bootstrap.Tab.getInstance(triggerEl).show()
            //resultadosISSS.innerHTML += mia[1] + "<br/><br>";
            parseISSS(mia[3]);
            POST_AJAX("/ajaxBuscar", variables + "&bd=BASE_TIGO&order=2", busquedaCompletadaBASE_TIGO, true)
        }
    }
}

function parseISSS(jsonData) {
    let datos = JSON.parse(jsonData);
    if (Object.keys(datos.items).length > 0) {
        var template = Handlebars.compile(document.getElementById('templateISSS').innerHTML);
        var html = template(datos);
        document.getElementById('containerISSS').innerHTML = html;
        //console.log("Patrono: " + datos[0].patrono);
    } else {
        document.getElementById('containerISSS').innerHTML = "<br><p>No se obtuvieron resultados</p>";
    }
}

function busquedaCompletadaBASE_TIGO() {
    if ((objeto.readyState == 4) && (objeto.status == 200)) {
        //btnBuscar.setAttribute("aria-busy", "false");
        mia = objeto.responseText.split('^-^');
        if (mia[0] == "yes") {
            resultados.classList.remove('d-none');
            parseBASE_TIGO(mia[3]);
            POST_AJAX("/ajaxBuscar", variables + "&bd=DUI&order=3", busquedaCompletadaDUI, true)
        }
    }
}

function parseBASE_TIGO(jsonData) {
    let datos = JSON.parse(jsonData);
    if (Object.keys(datos.items).length > 0) {
        var template = Handlebars.compile(document.getElementById('templateBASE_TIGO').innerHTML);
        var html = template(datos);
        document.getElementById('containerBASE_TIGO').innerHTML = html;
        //console.log("Patrono: " + datos[0].patrono);
    } else {
        document.getElementById('containerBASE_TIGO').innerHTML = "<br><p>No se obtuvieron resultados</p>";
    }
}

function busquedaCompletadaDUI() {
    if ((objeto.readyState == 4) && (objeto.status == 200)) {
        //btnBuscar.setAttribute("aria-busy", "false");
        mia = objeto.responseText.split('^-^');
        if (mia[0] == "yes") {
            resultados.classList.remove('d-none');
            //btnBuscarTxt.textContent = "Buscar";
            //btnBuscarSpin.classList.add('d-none');
            parseDUI(mia[3]);
            POST_AJAX("/ajaxBuscar", variables + "&bd=NIT&order=4", busquedaCompletadaNIT, true)
        }
    }
}

function parseDUI(jsonData) {
    let datos = JSON.parse(jsonData);
    if (Object.keys(datos.items).length > 0) {
        var template = Handlebars.compile(document.getElementById('templateDUI').innerHTML);
        var html = template(datos);
        document.getElementById('containerDUI').innerHTML = html;
        //console.log("Patrono: " + datos[0].patrono);
    } else {
        document.getElementById('containerDUI').innerHTML = "<br><p>No se obtuvieron resultados</p>";
    }
}

function busquedaCompletadaNIT() {
    if ((objeto.readyState == 4) && (objeto.status == 200)) {
        //btnBuscar.setAttribute("aria-busy", "false");
        mia = objeto.responseText.split('^-^');
        if (mia[0] == "yes") {
            resultados.classList.remove('d-none');
            //btnBuscarTxt.textContent = "Buscar";
            //btnBuscarSpin.classList.add('d-none');
            parseNIT(mia[3]);
            POST_AJAX("/ajaxBuscar", variables + "&bd=LICENCIA&order=5", busquedaCompletadaLICENCIA, true)
        }
    }
}

function parseNIT(jsonData) {
    let datos = JSON.parse(jsonData);
    if (Object.keys(datos.items).length > 0) {
        var template = Handlebars.compile(document.getElementById('templateNIT').innerHTML);
        var html = template(datos);
        document.getElementById('containerNIT').innerHTML = html;
        //console.log("Patrono: " + datos[0].patrono);
    } else {
        document.getElementById('containerNIT').innerHTML = "<br><p>No se obtuvieron resultados</p>";
    }
}

function busquedaCompletadaLICENCIA() {
    if ((objeto.readyState == 4) && (objeto.status == 200)) {
        //btnBuscar.setAttribute("aria-busy", "false");
        mia = objeto.responseText.split('^-^');
        if (mia[0] == "yes") {
            resultados.classList.remove('d-none');
            //btnBuscarTxt.textContent = "Buscar";
            //btnBuscarSpin.classList.add('d-none');
            parseLICENCIA(mia[3]);
            POST_AJAX("/ajaxBuscar", variables + "&bd=PLACAS_VEHICULOS2019&order=6", busquedaCompletadaVEHICULO, true)
        }
    }
}

function parseLICENCIA(jsonData) {
    let datos = JSON.parse(jsonData);
    if (Object.keys(datos.items).length > 0) {
        var template = Handlebars.compile(document.getElementById('templateLICENCIA').innerHTML);
        var html = template(datos);
        document.getElementById('containerLICENCIA').innerHTML = html;
        //console.log("Patrono: " + datos[0].patrono);
    } else {
        document.getElementById('containerLICENCIA').innerHTML = "<br><p>No se obtuvieron resultados</p>";
    }
}

function busquedaCompletadaVEHICULO() {
    if ((objeto.readyState == 4) && (objeto.status == 200)) {
        //btnBuscar.setAttribute("aria-busy", "false");
        mia = objeto.responseText.split('^-^');
        if (mia[0] == "yes") {
            resultados.classList.remove('d-none');
            btnBuscarTxt.textContent = "Buscar";
            btnBuscarSpin.classList.add('d-none');
            parseVEHICULO(mia[3]);
        }
    }
}

function parseVEHICULO(jsonData) {
    let datos = JSON.parse(jsonData);
    if (Object.keys(datos.items).length > 0) {
        var template = Handlebars.compile(document.getElementById('templateVEHICULO').innerHTML);
        var html = template(datos);
        document.getElementById('containerVEHICULO').innerHTML = html;
        //console.log("Patrono: " + datos[0].patrono);
    } else {
        document.getElementById('containerVEHICULO').innerHTML = "<br><p>No se obtuvieron resultados</p>";
    }
}