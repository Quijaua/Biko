const status_filter = document.getElementById('status');

const nucleo_filter = document.getElementById('nucleo');

const listaEspera_filter = document.getElementById('lista_espera');

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
        const shouldFormate = urlToFormate.pathname.includes('/search');
        if (!shouldFormate) {
            urlToFormate.pathname += '/search';
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

    url.searchParams.set('listaEspera', listaEspera);

    window.location.href = url.toString();
};

status_filter.addEventListener('change', () => {
    handleStatusChange(status_filter.value);
});

nucleo_filter.addEventListener('change', () => {
    handleNucleoChange(nucleo_filter.value);
});

listaEspera_filter.addEventListener('change', () => {
    handleListaEsperaChange(listaEspera_filter.value);
});