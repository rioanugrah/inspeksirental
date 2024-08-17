@section('script')
    <script>
        function _(el) {
            return document.getElementById(el);
        }

        $('#foto_speedometer').on('change',function(){
            var file = _("foto_speedometer").files[0];
            var formdata = new FormData();
            formdata.append("foto_speedometer", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerSpeedometer, false);
            ajax.addEventListener("load", completeHandlerSpeedometer, false);
            ajax.addEventListener("error", errorHandlerSpeedometer, false);
            ajax.addEventListener("abort", abortHandlerSpeedometer, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_speedometer',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerSpeedometer(event) {
            _("loaded_n_totalSpeedometer").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarSpeedometer").value = Math.round(percent);
            _("statusSpeedometer").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerSpeedometer(event) {
            _("statusSpeedometer").innerHTML = event.target.responseText;
            _("progressBarSpeedometer").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerSpeedometer(event) {
            _("statusSpeedometer").innerHTML = "Upload Failed";
        }

        function abortHandlerSpeedometer(event) {
            _("statusSpeedometer").innerHTML = "Upload Aborted";
        }


        $('#foto_setir').on('change',function(){
            var file = _("foto_setir").files[0];
            var formdata = new FormData();
            formdata.append("foto_setir", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerSetir, false);
            ajax.addEventListener("load", completeHandlerSetir, false);
            ajax.addEventListener("error", errorHandlerSetir, false);
            ajax.addEventListener("abort", abortHandlerSetir, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_setir',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerSetir(event) {
            _("loaded_n_totalSetir").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarSetir").value = Math.round(percent);
            _("statusSetir").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerSetir(event) {
            _("statusSetir").innerHTML = event.target.responseText;
            _("progressBarSetir").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerSetir(event) {
            _("statusSetir").innerHTML = "Upload Failed";
        }

        function abortHandlerSetir(event) {
            _("statusSetir").innerHTML = "Upload Aborted";
        }


        $('#foto_dasboard').on('change',function(){
            var file = _("foto_dasboard").files[0];
            var formdata = new FormData();
            formdata.append("foto_dasboard", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerDasboard, false);
            ajax.addEventListener("load", completeHandlerDasboard, false);
            ajax.addEventListener("error", errorHandlerDasboard, false);
            ajax.addEventListener("abort", abortHandlerDasboard, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_dasboard',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerDasboard(event) {
            _("loaded_n_totalDasboard").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarDasboard").value = Math.round(percent);
            _("statusDasboard").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerDasboard(event) {
            _("statusDasboard").innerHTML = event.target.responseText;
            _("progressBarDasboard").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerDasboard(event) {
            _("statusDasboard").innerHTML = "Upload Failed";
        }

        function abortHandlerDasboard(event) {
            _("statusDasboard").innerHTML = "Upload Aborted";
        }


        $('#foto_plafon').on('change',function(){
            var file = _("foto_plafon").files[0];
            var formdata = new FormData();
            formdata.append("foto_plafon", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerPlafon, false);
            ajax.addEventListener("load", completeHandlerPlafon, false);
            ajax.addEventListener("error", errorHandlerPlafon, false);
            ajax.addEventListener("abort", abortHandlerPlafon, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_plafon',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerPlafon(event) {
            _("loaded_n_totalPlafon").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarPlafon").value = Math.round(percent);
            _("statusPlafon").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerPlafon(event) {
            _("statusPlafon").innerHTML = event.target.responseText;
            _("progressBarPlafon").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerPlafon(event) {
            _("statusPlafon").innerHTML = "Upload Failed";
        }

        function abortHandlerPlafon(event) {
            _("statusPlafon").innerHTML = "Upload Aborted";
        }


        $('#foto_ac').on('change',function(){
            var file = _("foto_ac").files[0];
            var formdata = new FormData();
            formdata.append("foto_ac", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerAc, false);
            ajax.addEventListener("load", completeHandlerAc, false);
            ajax.addEventListener("error", errorHandlerAc, false);
            ajax.addEventListener("abort", abortHandlerAc, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_ac',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerAc(event) {
            _("loaded_n_totalAc").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarAc").value = Math.round(percent);
            _("statusAc").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerAc(event) {
            _("statusAc").innerHTML = event.target.responseText;
            _("progressBarAc").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerAc(event) {
            _("statusAc").innerHTML = "Upload Failed";
        }

        function abortHandlerAc(event) {
            _("statusAc").innerHTML = "Upload Aborted";
        }


        $('#foto_audio').on('change',function(){
            var file = _("foto_audio").files[0];
            var formdata = new FormData();
            formdata.append("foto_audio", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerAudio, false);
            ajax.addEventListener("load", completeHandlerAudio, false);
            ajax.addEventListener("error", errorHandlerAudio, false);
            ajax.addEventListener("abort", abortHandlerAudio, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_audio',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerAudio(event) {
            _("loaded_n_totalAudio").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarAudio").value = Math.round(percent);
            _("statusAudio").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerAudio(event) {
            _("statusAudio").innerHTML = event.target.responseText;
            _("progressBarAudio").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerAudio(event) {
            _("statusAudio").innerHTML = "Upload Failed";
        }

        function abortHandlerAudio(event) {
            _("statusAudio").innerHTML = "Upload Aborted";
        }


        $('#foto_jok').on('change',function(){
            var file = _("foto_jok").files[0];
            var formdata = new FormData();
            formdata.append("foto_jok", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerJok, false);
            ajax.addEventListener("load", completeHandlerJok, false);
            ajax.addEventListener("error", errorHandlerJok, false);
            ajax.addEventListener("abort", abortHandlerJok, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_jok',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerJok(event) {
            _("loaded_n_totalJok").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarJok").value = Math.round(percent);
            _("statusJok").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerJok(event) {
            _("statusJok").innerHTML = event.target.responseText;
            _("progressBarJok").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerJok(event) {
            _("statusJok").innerHTML = "Upload Failed";
        }

        function abortHandlerJok(event) {
            _("statusJok").innerHTML = "Upload Aborted";
        }


        $('#foto_electric_spion').on('change',function(){
            var file = _("foto_electric_spion").files[0];
            var formdata = new FormData();
            formdata.append("foto_electric_spion", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerElectricSpion, false);
            ajax.addEventListener("load", completeHandlerElectricSpion, false);
            ajax.addEventListener("error", errorHandlerElectricSpion, false);
            ajax.addEventListener("abort", abortHandlerElectricSpion, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_electric_spion',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerElectricSpion(event) {
            _("loaded_n_totalElectricSpion").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarElectricSpion").value = Math.round(percent);
            _("statusElectricSpion").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerElectricSpion(event) {
            _("statusElectricSpion").innerHTML = event.target.responseText;
            _("progressBarElectricSpion").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerElectricSpion(event) {
            _("statusElectricSpion").innerHTML = "Upload Failed";
        }

        function abortHandlerElectricSpion(event) {
            _("statusElectricSpion").innerHTML = "Upload Aborted";
        }


        $('#foto_power_window').on('change',function(){
            var file = _("foto_power_window").files[0];
            var formdata = new FormData();
            formdata.append("foto_power_window", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerPowerWindow, false);
            ajax.addEventListener("load", completeHandlerPowerWindow, false);
            ajax.addEventListener("error", errorHandlerPowerWindow, false);
            ajax.addEventListener("abort", abortHandlerPowerWindow, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_power_window',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerPowerWindow(event) {
            _("loaded_n_totalPowerWindow").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarPowerWindow").value = Math.round(percent);
            _("statusPowerWindow").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerPowerWindow(event) {
            _("statusPowerWindow").innerHTML = event.target.responseText;
            _("progressBarPowerWindow").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerPowerWindow(event) {
            _("statusPowerWindow").innerHTML = "Upload Failed";
        }

        function abortHandlerPowerWindow(event) {
            _("statusPowerWindow").innerHTML = "Upload Aborted";
        }


        $('#foto_lain_lain').on('change',function(){
            var file = _("foto_lain_lain").files[0];
            var formdata = new FormData();
            formdata.append("foto_lain_lain", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerLainLain, false);
            ajax.addEventListener("load", completeHandlerLainLain, false);
            ajax.addEventListener("error", errorHandlerLainLain, false);
            ajax.addEventListener("abort", abortHandlerLainLain, false);
            ajax.open("POST", "{{ route('cars.upload_file_inspeksi_interior_lain_lain',['id' => $car->id]) }}");
            ajax.setRequestHeader('X-CSRF-TOKEN', $('meta[name="_token"]').attr('content'));

            ajax.send(formdata);
        });

        function progressHandlerLainLain(event) {
            _("loaded_n_totalLainLain").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBarLainLain").value = Math.round(percent);
            _("statusLainLain").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandlerLainLain(event) {
            _("statusLainLain").innerHTML = event.target.responseText;
            _("progressBarLainLain").value = 100; //wil clear progress bar after successful upload
        }

        function errorHandlerLainLain(event) {
            _("statusLainLain").innerHTML = "Upload Failed";
        }

        function abortHandlerLainLain(event) {
            _("statusLainLain").innerHTML = "Upload Aborted";
        }
    </script>
@endsection
