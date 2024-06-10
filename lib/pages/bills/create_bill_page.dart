//home page
import 'package:qr_code/imports_screens.dart';

class CreateBillScreen extends StatefulWidget {
  const CreateBillScreen({super.key});

  @override
  State<CreateBillScreen> createState() => _CreateBillScreenState();
}

class _CreateBillScreenState extends State<CreateBillScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: backgroundColor,
      appBar: AppBar(
        automaticallyImplyLeading: true,
        backgroundColor: backgroundColor,
        foregroundColor: blackColor2,
        elevation: 0,
        centerTitle: false,
        title: const Text(
          "Create Bill Page",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: <Widget>[
          // create container with decoration
          ElevatedButton(
              onPressed: () {
                // go scanner page
                // Navigator.push(
                //   context,
                //   MaterialPageRoute(
                //       builder: (context) => QRCodeScannerScreen()),
                // );
              },
              child: Text("QR SCANNER")),
          ElevatedButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => QRCodeListScreen()),
                );
              },
              child: Text("QR LIST")),
          // ElevatedButton(
          //     onPressed: () {
          //       Navigator.push(
          //         context,
          //         MaterialPageRoute(
          //             builder: (context) => QRCodeResultScreen(
          //                   result: '5',
          //                 )),
          //       );
          //     },
          //     child: Text("Result Page")),
        ],
      ),
    );
  }
}
