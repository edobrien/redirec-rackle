@extends('mails.layout.template')

@section('content')
<table>
   <tr>
      <td>
         <h3 style="padding:7px 0px 7px 0px;">Hi,</h3>
         <br/>
          <p>Below user has requested reports.</p>
         <br/>
         <p>Name: {{$name}}</p>
         <br/>
          <p>Firm Name: {{$firm_name}}</p>
         <br/>
          <p>Position: {{$position}}</p>
         <br/>        
          <p>Email: {{$email}}</p>
         <br/>
          <p>Contact Number: {{$contact_number}}</p>
         <br/>
         <p>Reports Selected: </p>
         <ul>
              @foreach($selected_report as $report)
              <li> {{$report}}</li>
              @endforeach

         </ul>
         <br/>
         <p >Best Regards,</p>
         <p >The Rackle/p>
         <br>
      </td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
      <td class="container" style="background:rgba(33,150,243,1);">
         <div class="content">
            <table>
               <tr>
                   <td align="center" style="color: #fff"> {{ \App\SiteConstants::ADMIN_EMAIL }} &nbsp;&nbsp;
                  </td>
               </tr>
            </table>
         </div>
      </td>
   </tr>
</table>
@endsection