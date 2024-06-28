document.addEventListener('DOMContentLoaded', () => {
    const countrySelect = document.getElementById('correspondenseState');

    if (!countrySelect) {
        console.error('Element with id "correspondenseState" not found.');
        return;
    }

    // Fungsi untuk menambahkan negara ke elemen select
    const populateCountries = (countries) => {
        // Mengurutkan negara berdasarkan abjad
        countries.sort((a, b) => {
            const nameA = a.name.common.toUpperCase();
            const nameB = b.name.common.toUpperCase();

            if (nameA < nameB) {
                return -1;
            }
            if (nameA > nameB) {
                return 1;
            }
            return 0;
        });

        // Menambahkan negara ke dalam elemen select
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name.common;
            option.textContent = country.name.common;
            countrySelect.appendChild(option);
        });
    };

    // Mengambil data dari API REST Countries
    fetch('https://restcountries.com/v3.1/all')
        .then(response => response.json())
        .then(data => {
            populateCountries(data);
        })
        .catch(error => {
            console.error('Error fetching country data:', error);
            // Menggunakan data contoh lokal jika gagal
            const localData = [
                { name: { common: 'Indonesia' } },
                { name: { common: 'Malaysia' } },
                { name: { common: 'Singapore' } },
                { name: { common: 'Philippine' } },
                { name: { common: 'United States' } },
                { name: { common: 'China' } },
                { name: { common: 'Brazil' } },
                { name: { common: 'United Kingdom' } },
                { name: { common: 'Canada' } },
                { name: { common: 'Australia' } },
                { name: { common: 'Japan' } },
                { name: { common: 'Germany' } },
                { name: { common: 'France' } }
            ];
            populateCountries(localData);
        });
});