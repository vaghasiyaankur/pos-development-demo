@extends('layouts.panel.master')
@push('css')
    <style>
        .ribbon {
            opacity: 0;
            transition: all 0.5S ease;
            transform: translateY(50px);
        }

        .ribbon-box:hover .ribbon {
            opacity: 1;
            transform: translateY(0px);
        }
    </style>
@endpush
@section('content')
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                 <!-------Start page title start-------->
                 <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Pizza Management</h4>
                            <div class="page-title-right">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addcategory"><i class="ri-add-fill me-1 align-bottom"></i> Add category</button>
                            </div>
                            <!-- Modal For AddCategory Start-->
                            <div class="modal fade" id="addcategory" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Add Cataegories</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="teammembersName" class="form-label">Name</label>
                                                            <input type="text" class="form-control" id="teammembersName" placeholder="Enter name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-4">
                                                            <label for="formFile" class="form-label">Profile Images</label>
                                                            <input class="form-control" type="file" id="formFile">
                                                          </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Add Member</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!--end modal-content-->
                                </div><!--end modal-dialog-->
                            </div>
                            <!-- Moadal For Addcategory End -->
                        </div>
                    </div>
                </div>
                <!-------Start page title end --------->
                <section class="categories">
                     <!-------- CATEGORIES LIST START --------->
                    <div class="categories-main">
                        <div class="row">                           
                            <div class="col-sm-2 mb-2">
                                <div class="card card-body ribbon-box border shadow-none mb-lg-0 right px-2">
                                            <div class="ribbon ribbon-success ribbon-shape top-0"> 
                                                 <a href="#" class="trending-ribbon-text text-white" data-bs-toggle="modal" data-bs-target="#pizzaedit">Edit</a>
                                            </div>                                 
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/card-img5.png" alt="" class="avatar-sm rounded-circle"> 
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title fw-bold">Pizza</h5>
                                            <p class="mb-0"><span class="pe-1">Price:</span>120</p>
                                        </div>
                                    </div>                                    
                                </div>                                                                                        
                            </div>                     
                            <div class="col-sm-2 mb-2">
                                <div class="card card-body ribbon-box border shadow-none mb-lg-0 right px-2">
                                            <div class="ribbon ribbon-success ribbon-shape top-0"> 
                                                 <a href="#" class="trending-ribbon-text text-white" data-bs-toggle="modal" data-bs-target="#pizzaedit">Edit</a>
                                            </div>                                 
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/card-img5.png" alt="" class="avatar-sm rounded-circle"> 
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title fw-bold">Aglio</h5>
                                            <p class="mb-0"><span class="pe-1">Price:</span>120</p>
                                        </div>
                                    </div>                                    
                                </div>                                                                                        
                            </div>   
                            <div class="col-sm-2 mb-2">
                                <div class="card card-body ribbon-box border shadow-none mb-lg-0 right px-2">
                                            <div class="ribbon ribbon-success ribbon-shape top-0"> 
                                                 <a href="#" class="trending-ribbon-text text-white" data-bs-toggle="modal" data-bs-target="#pizzaedit">Edit</a>
                                            </div>                                 
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/card-img5.png" alt="" class="avatar-sm rounded-circle"> 
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title fw-bold">Margherita</h5>
                                            <p class="mb-0"><span class="pe-1">Price:</span>120</p>
                                        </div>
                                    </div>                                    
                                </div>                                                                                        
                            </div> 
                            <div class="col-sm-2 mb-2">
                                <div class="card card-body ribbon-box border shadow-none mb-lg-0 right px-2">
                                            <div class="ribbon ribbon-success ribbon-shape top-0"> 
                                                 <a href="#" class="trending-ribbon-text text-white" data-bs-toggle="modal" data-bs-target="#pizzaedit">Edit</a>
                                            </div>                                 
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/card-img5.png" alt="" class="avatar-sm rounded-circle"> 
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title fw-bold">Pizza</h5>
                                            <p class="mb-0"><span class="pe-1">Price:</span>120</p>
                                        </div>
                                    </div>                                    
                                </div>                                                                                        
                            </div>           
                            <div class="col-sm-2 mb-2">
                                <div class="card card-body ribbon-box border shadow-none mb-lg-0 right px-2">
                                            <div class="ribbon ribbon-success ribbon-shape top-0"> 
                                                 <a href="#" class="trending-ribbon-text text-white" data-bs-toggle="modal" data-bs-target="#pizzaedit">Edit</a>
                                            </div>                                 
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/card-img5.png" alt="" class="avatar-sm rounded-circle"> 
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title fw-bold">Pizza</h5>
                                            <p class="mb-0"><span class="pe-1">Price:</span>120</p>
                                        </div>
                                    </div>                                    
                                </div>                                                                                        
                            </div>           
                            <div class="col-sm-2 mb-2">
                                <div class="card card-body ribbon-box border shadow-none mb-lg-0 right px-2">
                                            <div class="ribbon ribbon-success ribbon-shape top-0"> 
                                                 <a href="#" class="trending-ribbon-text text-white" data-bs-toggle="modal" data-bs-target="#pizzaedit">Edit</a>
                                            </div>                                 
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/card-img5.png" alt="" class="avatar-sm rounded-circle"> 
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h5 class="card-title fw-bold">Pizza</h5>
                                            <p class="mb-0"><span class="pe-1">Price:</span>120</p>
                                        </div>
                                    </div>                                    
                                </div>                                                                                        
                            </div>                                                                              
                        </div>                         
                    </div>                                      
                    <!-------- CATEGORIES LIST END --------->                               
                        <!-- Modal For AddCategory Start-->
                        <div class="modal fade" id="pizzaedit" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Add Cataegories</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="teammembersName" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="teammembersName" placeholder="Enter name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title mb-0">Profile Picture Selection</h4>
                                                        </div><!-- end card header -->
                                                        <div class="card-body">
                                                            <p class="text-muted">FilePond is a JavaScript library with profile picture-shaped file upload variation.</p>
                                                            <div class="avatar-xl mx-auto">
                                                                <div class="avatar-xl mx-auto">
                                                                    <input type="file" 
                                                                        class="filepond filepond-input-circle"
                                                                        name="filepond"
                                                                        accept="image/png, image/jpeg, image/gif"/>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <!-- end card body -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <div class="form-check form-switch form-switch-lg form-switch-success" dir="ltr">
                                                            <input type="checkbox" class="form-check-input" id="customSwitchsizelg" checked="">                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Moadal For Addcategory End -->
                </section>
                                
            </div>
          
        </div>
        <!-- end main content-->
@endsection