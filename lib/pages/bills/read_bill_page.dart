import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:qr_code/pages/qr_pages/qr_code_scanner_screen.dart';
import 'package:qr_code/theme/theme.dart';
import 'package:qr_code/utils/app_constant.dart';
import 'package:qr_code/utils/images.dart';

class ReadBillScreen extends StatefulWidget {
  const ReadBillScreen({super.key});

  @override
  State<ReadBillScreen> createState() => _ReadBillScreenState();
}

class _ReadBillScreenState extends State<ReadBillScreen> {
  bool _isLoading = false;
  String _resultMessage = '';
  String number = "243"; // Placeholder for QR code result, replace as needed

  Future<void> _readBill(String billType, String tc) async {
    setState(() {
      _isLoading = true;
      _resultMessage = '';
    });

    final response = await http.post(
      Uri.parse('${AppConstant.url}read_bill.php'),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'tc': tc,
        'bill_type': billType,
      }),
    );

    if (response.statusCode == 200) {
      final Map<String, dynamic> responseData = jsonDecode(response.body);
      setState(() {
        if (responseData.containsKey('error')) {
          _resultMessage = responseData['error'];
          if (_resultMessage == "true") {
            Navigator.push(
              context,
              MaterialPageRoute(
                builder: (context) => QRCodeScannerScreen(
                  result: number,
                  tc: tc,
                  billType: billType,
                ),
              ),
            );
          }
        } else if (responseData.containsKey('message')) {
          _resultMessage = responseData['message'];
          if (_resultMessage == "true") {
            Navigator.push(
              context,
              MaterialPageRoute(
                builder: (context) => QRCodeScannerScreen(
                  result: number,
                  tc: tc,
                  billType: billType,
                ),
              ),
            );
          }
        } else if (responseData.containsKey('message')) {
          _resultMessage =
              "true"; // Assuming responseData['qr_code'] means success
          if (_resultMessage == "true") {
            Navigator.push(
              context,
              MaterialPageRoute(
                builder: (context) => QRCodeScannerScreen(
                  result: number,
                  tc: tc,
                  billType: billType,
                ),
              ),
            );
          }
        }
      });
    } else {
      setState(() {
        _resultMessage = 'An error occurred. Please try again.';
      });
    }

    setState(() {
      _isLoading = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: backgroundColor,
      appBar: AppBar(
        automaticallyImplyLeading: false,
        backgroundColor: backgroundColor,
        foregroundColor: blackColor2,
        elevation: 0,
        centerTitle: false,
        title: const Text(
          "Faturayı Oku",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
        children: <Widget>[
          BillType(
            type: 'doğalgaz',
            name: 'Doğalgaz Faturası',
            image: ImagesConstant.natural_gas,
            onTap: _readBill,
          ),
          BillType(
            type: 'elektrik',
            name: 'Elektrik Faturası',
            image: ImagesConstant.electricity,
            onTap: _readBill,
          ),
          BillType(
            type: 'su',
            name: 'Su Faturası',
            image: ImagesConstant.water,
            onTap: _readBill,
          ),
          _isLoading
              ? CircularProgressIndicator()
              : Text(
                  _resultMessage,
                  style: TextStyle(color: Colors.red, fontSize: 18),
                ),
        ],
      ),
    );
  }
}

class BillType extends StatelessWidget {
  final String type;
  final String name;
  final String image;
  final Function(String, String) onTap;
  const BillType({
    required this.type,
    required this.name,
    required this.image,
    required this.onTap,
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {
        final tcController = TextEditingController();
        showDialog(
          context: context,
          builder: (context) {
            return AlertDialog(
              title: const Text("TC'yi girin"),
              content: TextFormField(
                controller: tcController,
                decoration: const InputDecoration(
                  labelText: "TC",
                  errorBorder: OutlineInputBorder(
                    borderSide: BorderSide(width: 1, color: Colors.red),
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(width: 1, color: Colors.green),
                  ),
                  focusedErrorBorder: OutlineInputBorder(
                    borderSide: BorderSide(width: 1, color: Colors.green),
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderSide: BorderSide(width: 1, color: primaryColor),
                  ),
                ),
              ),
              actions: <Widget>[
                TextButton(
                  child: const Text("Tamamdır"),
                  onPressed: () {
                    Navigator.of(context).pop();
                    onTap(type, tcController.text);
                  },
                ),
              ],
            );
          },
        );
      },
      child: Center(
        child: Container(
          margin: const EdgeInsets.all(10),
          width: double.infinity,
          height: 150, // Adjust the height as needed
          decoration: BoxDecoration(
            image: DecorationImage(
              image: AssetImage(image),
              fit: BoxFit.cover,
            ),
            borderRadius: BorderRadius.circular(10),
          ),
          child: Center(
            child: Text(
              name,
              style: const TextStyle(
                color: Colors.white,
                fontSize: 24,
                fontWeight: FontWeight.bold,
                backgroundColor: Colors
                    .black54, // Optional: Add background color to text for better readability
              ),
            ),
          ),
        ),
      ),
    );
  }
}
