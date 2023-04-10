<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      body {
        height: 100%;
        display: block;
        margin: 8px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
          Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
          "Segoe UI Symbol";
      }
      .contenedor {
        margin: auto;
        /* width: 100%; */
        height: 96vh;
        background-color: #ff6a002d;
      }

      .principal {
        margin: auto;
        width: 40%;
        height: inherit;
        /* background-color: #ff6a004b; */
      }

      .titulo {
        /* background-color: #ff6a004b; */
        height: 15%;
        text-align: center;
        display: flex;
        align-items: center;
      }

      .tituloi {
        margin: 0px auto;
        color: #3d4852;
        font-size: 19px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        width: 100%;
      }

      .cuerpo {
        height: 70%;
        border-radius: 8px;
        background-color: #fdfbfb;
      }

      .saludo {
        margin: 0;
        padding: 4vh;
      }

      .pie {
        height: 15%;
        /* background-color: blueviolet; */
        display: flex;
        align-items: center;
        text-align: center;
      }

      .pief {
        color: #b0adc5;
        font-size: 12px;
        text-align: center;
        margin: 0;
        display: inline-block;
        width: 100%;
      }

      .button {
        background-color: #ff6a00d8; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 8px;
        border: 1px solid #6b6968a4;
        margin: auto;
      }

      .divBtn {
        display: flex;
        align-items: center;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="contenedor">
      <div class="principal">
        <div class="titulo">
          <a class="tituloi">IPRODHA</a>
        </div>
        <div class="cuerpo">
          <h2 class="saludo">Saludos, {{$name}}.</h2>
          <p class="saludo">La oferta de obra "{{$oferta}}" fue rechazada debido a:</p>
          <p class="saludo">{{$comentario}}</p>
          <p class="saludo">pero la obra se encuentra nuevamente activa para que se puedan solventar los problemas y volver a presentarlo.</p>
          <div class="divBtn">
            <a class="button" href="#">Ir a la oferta</a>
          </div>
        </div>
        <div class="pie">
          <p class="pief">{{ $footer ?? '' }}</p>
        </div>
      </div>
    </div>
  </body>
</html>