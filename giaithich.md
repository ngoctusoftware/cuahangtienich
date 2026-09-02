Hãy xây dựng hệ thống bán hàng gồm có các phần như sau:
1. Website bán hàng: Sử dụng code PHP Laravel: các components, bootstrap, css, js dể thực hiện các công việc sau
    - Giao diện website bán hàng giống 100% như hình ảnh 1 được đính kèm
    - Các chức năng như sau: 
        + Đăng nhập hệ thống (Khách - Mua hàng/ Admin - Quản trị hệ thống)
        + Hiển thị sản phẩm theo: Sản phẩm mới, Sản phẩm bán chạy, sản phẩm nổi bật
        + Thêm sản phẩm vào giỏ hàng, Mua hàng, Thanh toán mua hàng: COD, Thanh toán trực tuyến, Chuyển khoản
        + Widget: Zalo, Message Facebook, Phone.
        + Website có thể chạy nhiều ngôn ngữ: Cho phép chuyển ngôn ngữ ở phần header (Ngôn ngữ sẽ được quản trị trong phần admin).
2. Website Admin: Sử dụng code PHP Laravel: các components, bootstrap, css, js dể thực hiện các công việc sau
    - Giao diện quản trị được xây dựng theo hình ảnh số 2 được đính kèm.
    - Các chức năng:        
        + Quản lý thông tin: địa chỉ logo, Tên website, số điện thoại, email, ....
        + Quản lý nội dung website: tất cả nội dung hiển thị 
        + Quản lý danh mục
        + Quản lý sản phẩm theo từng danh mục.
        + Quản lý người dùng.
        + Quản lý phân quyền.
        + Quản lý đơn hàng
        + Quản lý thanh toán
        + Quản lý nhóm khách hàng.
        + Quản lý khách hàng
        + Quản lý ngôn ngữ: địa chỉ biểu tượng, tên ngôn ngữ ...
3. CSDL: dùng mysql
4. Dùng queue để tạo hàng đợi cho các chức năng gửi: Email, ...
5. Dùng Redis để tạo cache tằng tốc độ xử lý website
Yêu cầu: Hệ thống sử dụng cấu trúc design pattern 
