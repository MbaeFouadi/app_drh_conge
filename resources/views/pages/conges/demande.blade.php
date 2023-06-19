@extends('pages.conges.conges')
@section('meta-title', $title = "Congé")
@section('content')
<section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-6">
          <!-- small box -->
          <div class="smallbox bg-success text-center p-3 ">
            <div class="inner">
              <h3>Demande de congé</h3>

              <p>Bienvenu sur la page de demande de congé pour les employés de l'univestité de comores.</p>
              <p>
                Tout employé de l'UDC a droit de prendre des congés chaque année selon les nombres de jours de congé.<br> Le nombre de jours de congés par an est de 30 jours.
                </p>
                <span class="text-warning"><i>A noter que pour vous, le nombre de jours restants des congés est <b>
                  <?php if (isset($emp->jour)){ ?>
                    @if($emp->jour==0 || $emp->jour==1)
                    {{$emp->jour}} jour.
                    @else
                    {{$emp->jour}} jours.
                    @endif
                  <?php }else{ echo "30 jours"; } ?>



                </b></i></span>

                <p><br>Veuiller renseigner le formulaire ci-dessous pour demander un congé. </p><hr>

                <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                  @if(session()->has('jour0'))
        						<p class="text-danger text-center">
        						° {{ session()->get('jour0') }}
                  </p>
        					@endif
                  @if(session()->has('jourGrand'))
        						<p class="text-danger text-center">
        						° {{ session()->get('jourGrand') }}
                  </p>
        					@endif
                  @if(session()->has('encours'))
        						<p class="text-danger text-center">
        						° {{ session()->get('encours') }}
                  </p>
        					@endif
                  @if(session()->has('dateinf'))
        						<p class="text-danger text-center">
      						  ° {{ session()->get('dateinf') }}
                  </p>
        					@endif
                    <form action="{{route('conges')}}" method="post">
                        @csrf
                        <table class="pb-3">
                            <tr>
                                <td class="p-3"><label for="hrd">Date début du congé</label></td>
                                <td class="p-3"><input type="date" name="datedebut" id="hrd" class="form-control" required></td>
                                <td>@error('datedebut')
                                    <p class="text-danger">{{ $message }}</p>
                                  @enderror</td>
                            </tr>
                            <tr>
                                <td class="p-3"><label for="hr">Nombre de jours</label></td>
                                <td class="p-3"><input type="number" min="1" max="30" name="nombre" id="hr" class="form-control" required></td>
                                <td>@error('nombre')
                                    <p class="text-danger">{{ $message }}</p>
                                  @enderror</td>
                            </tr>
                        </table>
                        <input type="number" value="1" hidden>

                        <button type="submit" class="btn btn-info">Demander</button>
                    </form>
                </div>
                </div>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-bag"></i> --}}
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>

        <!-- ./col -->
      </div>
    </div>
  </section>
@endsection
