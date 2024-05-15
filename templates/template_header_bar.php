<header class="article-container-header d-flex justify-content-between">
  <span class="article-container-title" style="font-size: 26px">
    Home
  </span>
  <div class="d-flex justify-content-center align-items-center">
    <button class="icon-button bg-black justify-content-center me-1 d-flex align-items-center" style="height: 25px; width: 60px; border-radius: 100%/60px;">
      <i class="fa fa-usd me-1 text-dark rounded-circle bg-white" style="font-size: 12px;padding: 2px 5px;"></i>
      <span class=" text-white" style="font-size: 12px;"><?php echo $_SESSION['point']; ?></span>
    </button>
    <button class="icon-button" >
      <i class="fa fa-search fs-4 fw-bold" id="offcanvas-search-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch"></i>
    </button>

    <div style="width: 540px; height: 280px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasSearchLabel">
      <div class="offcanvas-header">
        <button type="button" class="btn-close fs-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body small" style="font-size: 17px;">

        <div class="d-flex justify-content-between align-items-center mb-4" style="cursor: pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasGender" aria-controls="offcanvasGender">
          <strong><span>Show me</span></strong>
          <span>{{partner_gender_name}} <i class="fa fa-chevron-right"></i></span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4" style="cursor: pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAge" aria-controls="offcanvasAge">
          <strong><span>Age range</span></strong>
          <span>{{age_limit}} <i class="fa fa-chevron-right"></i></span>
        </div>
        <button class="btn btn-lg rounded-pill btn-dark w-100" ng-click="applyFilter()">Apply Filters</button>
      </div>
    </div>

    <div style="width: 540px; height: 370px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasGender" aria-labelledby="offcanvasGenderLabel">
      <div class="offcanvas-header py-0">
        <span type="button" ng-click="backSearchOffcanvas()" class="fs-4 float-left" aria-label="Back"><i class="fa fa-chevron-left"></i></span>
      </div>
      <div class="offcanvas-body small">
        <div class="fs-5 fw-bold mb-3">Which gender would you like to see?</div>

        <label id="gender-label-man" class="bg-secondary-subtle d-flex justify-content-between align-items-center rounded-5 px-3 py-2 mb-2" style="font-size: 17px;">
          <div>Man</div>
          <input type="radio" class="btn" name="gender" value="0" style="width: 20px; height: 20px;" id="gender-man">
        </label>

        <label id="gender-label-woman" class="bg-secondary-subtle d-flex justify-content-between align-items-center rounded-5 px-3 py-2 mb-2" style="font-size: 17px;">
          <div>Woman</div>
          <input type="radio" class="btn" name="gender" value="1" style="width: 20px; height: 20px;" id="gender-woman">
        </label>

        <label id="gender-label-every" class="bg-secondary-subtle d-flex justify-content-between align-items-center rounded-5 px-3 py-2 mb-4" style="font-size: 17px;">
          <div>Everyone</div>
          <input type="radio" class="btn" name="gender" value="2" style="width: 20px; height: 20px;" id="gender-every">
        </label>

        <button class="btn btn-lg rounded-pill btn-dark w-100" ng-click="filterGender()">Apply</button>
      </div>
    </div>

    <div style="width: 540px; height: 320px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasAge" aria-labelledby="offcanvasAgeLabel">
      <div class="offcanvas-header py-0">
        <span type="button" ng-click="backSearchOffcanvas()" class="fs-4 float-left" aria-label="Back"><i class="fa fa-chevron-left"></i></span>
      </div>
      <div class="offcanvas-body small">
        <div class="fs-5 fw-bold mb-3">Age range</div>

        <div class="d-flex justify-content-between mb-4"  style="font-size: 17px;">
            <div style="width:48%;">
              <label for="min-age"><strong>Minimum</strong></label>
                <select name="min-age" id="min-age" class="form-select form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2" ng-model="min_age" ng-change="chooseMinAge()">
                    <option value="" selected>Minimum Age</option>
                    <option value='{{age}}' ng-repeat="age in min_ages">{{age}}</option>
                </select>
            </div>
            
            <div style="width:48%;">
                <label for="max-age"><strong>Maximum</strong></label>
                <select name="max-age" id="max-age" class="form-select form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2" ng-model="max_age" ng-change="chooseMaxAge()">
                    <option value="" selected>Maximum Age</option>
                    <option value='{{age}}' ng-repeat="age in max_ages">{{age}}</option>
                </select>
            </div>
        </div>

        <button class="btn btn-lg rounded-pill btn-dark w-100" ng-click="filterAge()">Apply</button>
      </div>
    </div>
  </div>
</header>