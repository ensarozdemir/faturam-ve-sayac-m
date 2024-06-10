import 'package:qr_code/imports_screens.dart';
import 'package:qr_flutter/qr_flutter.dart';

class QRCodeListScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: true,
        backgroundColor: backgroundColor,
        foregroundColor: blackColor2,
        elevation: 0,
        centerTitle: false,
        title: const Text(
          "QR Code List Screen",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: GridView.builder(
        gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
          crossAxisCount: 3,
        ),
        itemCount: 100,
        itemBuilder: (context, index) {
          return Card(
            child: Center(
              child: QrImageView(
                data: (index + 1).toString(),
                version: QrVersions.auto,
                size: 100.0,
              ),
            ),
          );
        },
      ),
    );
  }
}
