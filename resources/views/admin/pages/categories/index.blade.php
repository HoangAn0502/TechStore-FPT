@extends('admin.master')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">Thêm mới danh mục</h4>
                <form method="POST" action="{{route('createCate')}}" enctype="multipart/form-data" class="form-inline" id="form-add">
                  @csrf
                  <div>
                    <label class="sr-only" for="inlineFormInputName2">Tên Danh Mục</label>
                    <input type="text" name="name" class="form-control mb-2 mr-sm-2" id="fullname"  placeholder="Tên Danh Mục">
                    <span style="font-size: 15px; color: #f33a58; line-height: 3px;   display: block;" class="form-message"></span>
                  </div>
                  <div>
                    <label class="sr-only" for="inlineFormInputName2">Hình Ảnh</label>
                    <input type="file" name="file_upload" class="form-control mb-2 mr-sm-2" id="avatar" placeholder="Tên Danh Mục">
                    <span style="font-size: 15px; color: #f33a58; line-height: 3px;   display: block;" class="form-message"></span>
                  </div>
                  <button type="submit" class="btn btn-primary mb-2">Thêm mới</button>
                </form>
            </div>
            </div>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Danh Mục</h4>
                <div class="table-responsive pt-3">
                  <table id="recent-purchases-listing" class="table table-bordered">
                    <thead>
                      <tr>
                        <th>
                          #
                        </th>
                        <th>
                          Tên Danh Mục
                        </th>
                        <th>
                          Số lượng Sản Phẩm
                        </th>
                        <th>
                          Hành động
                        </th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($allCate as $cate)
                      <tr>
                        <td>
                          {{$cate->id}}
                        </td>
                        <td>
                          <a href="{{route('getCateItems',$cate->id)}}">{{$cate->name}}</a>
                        </td>
                        <td>
                          <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="20"></div>
                          </div>
                        </td>
                        <td style="width: 15%">
                            <a href="{{route('loadEditCate',$cate->id)}}"><button type="button" class="btn btn-primary">Sửa</button></a>
                            <a href="{{route('deleteCate',$cate->id)}}" onclick="return confirm('Xóa mục này?')"><button type="button" class="btn btn-danger">Xóa</button></a>
                        </td>
                      </tr>
                      @endforeach
                      
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>

<script>
    

function Validator(options){
    var formElement = document.querySelector(options.form);
    var selectorRules = {}
// hàm thực hiện validate
var selectorRules = {}
function validate(inputElement, rule) {
      var input =inputElement.parentElement.querySelector('.form-control')
      var errorElement = inputElement.parentElement.querySelector('.form-message');
      var errorMessage 
      //
        var rules = selectorRules[rule.selector]
        
        for(var i = 0; i < rules.length; ++i){
          errorMessage = rules[i](inputElement.value)
          if (errorMessage) break;
        }
        if (errorMessage) {
          errorElement.innerText = errorMessage;
          input.style.borderColor = '#f33a58'
        }else{
          errorElement.innerText = ''
          input.style.borderColor = ''
        }
        return !errorMessage;
    }
    
    // lấy element của form
    if(formElement) {
      formElement.onsubmit = function(e) {
        

        var isFormValid = true

        options.rules.forEach( function(rule) {
         
          var inputElement = formElement.querySelector(rule.selector)
          var isValid = validate(inputElement,rule)
          if(!isValid) {
            isFormValid = false
          }
        });
        

        if(isFormValid){
          formElement.submit()
        }else{
          e.preventDefault();
        }
      }
        // lặp qua mỗi rule và xửa lý sự kiện
      options.rules.forEach( function(rule) {
        //lu lai cac rules cho moi input
        
        if(Array.isArray(selectorRules[rule.selector])) {
          selectorRules[rule.selector].push(rule.test)
        }else{
          selectorRules[rule.selector] = [rule.test]
        }

        var inputElement = formElement.querySelector(rule.selector)
        var errorElement = inputElement.parentElement.querySelector(options.errorSelector);
        var input =inputElement.parentElement.querySelector('.form-control')

          if(inputElement) {
            inputElement.onblur = function() {
              validate(inputElement,rule)
            }
            inputElement.oninput = function() {
              errorElement.innerHTML = ''
              input.style.borderColor = ''
            }
          }
      })
    }
}

Validator.isRequired = function (selector) {
    return {
      selector,
      test(value) {
        return value.trim() ? undefined : 'Vui lòng nhập tên danh mục'
      }
    }
}
Validator.isAvatar = function (selector) {
  return {
    selector,
    test(value) {
      return value ? undefined : 'Vui lòng chọn ảnh'
    }
  }
}

   Validator({
    form: '#form-add',
    errorSelector: '.form-message',
    rules: [
      Validator.isRequired('#fullname'),
      // Validator.isRequired('#avatar'),
      Validator.isAvatar('#avatar')
    ],
  })
</script>

@endsection