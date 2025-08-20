const status_filter = document.getElementById('status');

const nucleo_filter = document.getElementById('nucleo');

const listaEspera_filter = document.getElementById('lista_espera');

const cidade_filter = document.getElementById('cidade');

const date_filter = document.getElementById('date');

const areas_conhecimento_filter = document.getElementsByClassName('areas_conhecimento');

const disciplina_filter = document.getElementsByClassName('disciplina');

const limparFiltrosButton = document.getElementById('limparFiltros');

const handleStatusChange = (status) => {
    const handleUrlFormated = () => {
        const urlToFormate = new URL(window.location.href);
        const shouldFormate = urlToFormate.pathname.includes('/search');
        if (!shouldFormate) {
            urlToFormate.pathname += '/search';
        }

        return urlToFormate;
    };

    const url = handleUrlFormated();

    url.searchParams.set('status', status);

    window.location.href = url.toString();
};

const handleNucleoChange = (nucleo) => {
    const handleUrlFormated = () => {
        const urlToFormate = new URL(window.location.href);
        if (!urlToFormate.pathname.endsWith('/search')) {
            if (urlToFormate.pathname.endsWith('/')) {
                urlToFormate.pathname += 'search';
            } else {
                urlToFormate.pathname += '/search';
            }
        }

        return urlToFormate;
    };

    const url = handleUrlFormated();

    url.searchParams.set('nucleo', nucleo);

    window.location.href = url.toString();
};

const handleListaEsperaChange = (listaEspera) => {
    const handleUrlFormated = () => {
        const urlToFormate = new URL(window.location.href);
        const shouldFormate = urlToFormate.pathname.includes('/search');
        if (!shouldFormate) {
            urlToFormate.pathname += '/search';
        }

        return urlToFormate;
    };

    const url = handleUrlFormated();

    url.searchParams.set('lista_espera', listaEspera);

    window.location.href = url.toString();
};

const handleCidadeChange = (cidade) => {
    const handleUrlFormated = () => {
        const urlToFormate = new URL(window.location.href);
        const shouldFormate = urlToFormate.pathname.includes('/search');
        if (!shouldFormate) {
            urlToFormate.pathname += '/search';
        }

        return urlToFormate;
    };

    const url = handleUrlFormated();

    url.searchParams.set('cidade', cidade);

    window.location.href = url.toString();
};

const handleDateChange = (date) => {

    const handleUrlFormated = () => {
        const urlToFormate = new URL(window.location.href);
        const shouldFormate = urlToFormate.pathname.includes('/search');
        if (!shouldFormate) {
            urlToFormate.pathname += '/search';
        }

        return urlToFormate;
    };

    const url = handleUrlFormated();

    url.searchParams.set('date', date);

    window.location.href = url.toString();
};

const handleAreasConhecimentoChange = (areas_conhecimento) => {
    
    const handleUrlFormated = () => {
        const urlToFormate = new URL(window.location.href);
        const shouldFormate = urlToFormate.pathname.includes('/search');
        if (!shouldFormate) {
            urlToFormate.pathname += '/search';
        }

        return urlToFormate;
    };

    const url = handleUrlFormated();

    url.searchParams.set('areas_conhecimento', areas_conhecimento);

    window.location.href = url.toString();
}

const disciplinaChange = (disciplina) => {
    const handleUrlFormated = () => {
        const urlToFormate = new URL(window.location.href);
        const shouldFormate = urlToFormate.pathname.includes('/search');
        if (!shouldFormate) {
            urlToFormate.pathname += '/search';
        }

        return urlToFormate;
    };

    const url = handleUrlFormated();

    url.searchParams.set('disciplina', disciplina);

    window.location.href = url.toString();
}

status_filter ? status_filter.addEventListener('change', () => {
    handleStatusChange(status_filter.value);
}) : null;

nucleo_filter ? nucleo_filter.addEventListener('change', () => {
    console.log('eventlistener on nucleo');
    handleNucleoChange(nucleo_filter.value);
}) : null;

listaEspera_filter ? listaEspera_filter.addEventListener('change', () => {
    handleListaEsperaChange(listaEspera_filter.value);
}) : null;

cidade_filter ? cidade_filter.addEventListener('change', () => {
    handleCidadeChange(cidade_filter.value);
}) : null;

date_filter ? date_filter.addEventListener('change', () => {
    handleDateChange(date_filter.value);
}) : null;

limparFiltrosButton ? limparFiltrosButton.addEventListener('click', () => {
    const url = window.location.origin + window.location.pathname;
  
    const baseUrl = url.replace(/\/search\/?$/, '');
  
    window.location.href = baseUrl;
  }) : null;

areas_conhecimento_filter ? Array.from(areas_conhecimento_filter).forEach((area) => {
    area.addEventListener('click', () => {
        handleAreasConhecimentoChange(area.value);
    })
}) : null;

disciplina_filter ? Array.from(disciplina_filter).forEach((disciplina) => {
    disciplina.addEventListener('click', () => {
        disciplinaChange(disciplina.value);
    })
}) : null;