import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:qr_code/imports_screens.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  bool _isLoading = false;
  List<dynamic> _bills = [];

  @override
  void initState() {
    super.initState();
    _fetchUserBills();
  }

  Future<void> _fetchUserBills() async {
    setState(() {
      _isLoading = true;
    });

    String? tc = await SharedPreferencesService.getUserTc();

    if (tc != null) {
      final response = await http.post(
        Uri.parse('${AppConstant.url}get_user_bills.php'),
        headers: <String, String>{
          'Content-Type': 'application/json; charset=UTF-8',
        },
        body: jsonEncode(<String, String>{
          'tc': tc,
        }),
      );

      if (response.statusCode == 200) {
        final List<dynamic> responseData = jsonDecode(response.body);
        setState(() {
          _bills = responseData;
        });
      } else {
        // Handle error
      }
    } else {
      // Handle error: TC not found
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
          "Ana Sayfa",
          style: TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
      body: _isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              itemCount: _bills.length,
              itemBuilder: (context, index) {
                return ListTile(
                  title: Text('Fatura Türü: ${_bills[index]['bill_type']}'),
                  subtitle: Text('Miktar: ${_bills[index]['result']} tl'),
                  trailing: Text(
                      'Durum: ${_bills[index]['status'] == 'paid' ? 'Ödendi' : 'Ödenmedi'}'),
                );
              },
            ),
    );
  }
}
