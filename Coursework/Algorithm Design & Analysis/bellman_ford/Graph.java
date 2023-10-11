// jdh CS224 Spring 2023

import java.util.Arrays;
import java.util.List;
import java.util.ArrayList;

public class Graph {
    List<Node> nodes;

    public Graph() {
        this.nodes = new ArrayList<Node>();
    }

    public void addNode(Node node) {
        // make sure this node does not already exist
        for (Node n : this.nodes) {
            if (n == node) {
                System.out.println("ERROR: node " + n + " is already in graph");
                return;
            }
        }
        this.nodes.add(node);
    } // addNode()

    public void addEdge(Node n1, Node n2, int weight) {
        // outgoing edge
        int idx1 = this.nodes.indexOf(n1);
        if (idx1 < 0) {
            System.out.println("ERROR: node " + n1.name + " not found in graph");
            return;
        }

        int idx2 = this.nodes.indexOf(n2);
        if (idx2 < 0) {
            System.out.println("ERROR: node " + n2.name + " not found in graph");
            return;
        }

        n1.addEdge(n2, weight);
    } // addEdge()

    public void print() {
        for (Node n : this.nodes) {
            System.out.print("Node " + n.name + " out:");
            for (Edge e : n.adjlistOut)
                System.out.print(" " + e);
            System.out.println();
            System.out.print("Node " + n.name + " in:");
            for (Edge e : n.adjlistIn)
                System.out.print(" " + e);
            System.out.println();
        }
    } // print()

    //----------------------------------------------------------------

    public Object[] bellmanFord(Node t) {
        // implement this
        int[] M = new int[nodes.size() + 1];
        int[] first = new int[nodes.size() + 1];
        for (int i = 1; i < nodes.size() + 1; i++) {
            if (nodes.get(i - 1) == t) {
                M[i] = 0;
            } else {
                M[i] = Integer.MAX_VALUE / 2;
            }
            first[i] = -1;
        }
        boolean changed = true;
        while (changed) {
            changed = false;
            int[] Mnew = new int[nodes.size() + 1];
            for (int i = 1; i < nodes.size() + 1; i++) {
                Mnew[i] = M[i];
            }
            for (Node u : nodes) {
                if (u == t) {
                    first[u.name] = u.name;
                }
                for (Edge e : u.adjlistOut) {
                    Node v = e.n2;
                    if (e.weight + M[v.name] < M[u.name]) {
                        Mnew[u.name] = e.weight + M[v.name];
                        first[u.name] = v.name;
                        changed = true;
                    }
                }
            }
            for (int i = 1; i < nodes.size() + 1; i++) {
                M[i] = Mnew[i];
            }
        }
        Object[] result = new Object[2];
        result[0] = M;
        result[1] = first;
        return result;

    } // bellmanFord()

    //----------------------------------------------------------------

    public Object[] bellmanFordPush(Node t) {
        boolean[] changedArray = new boolean[nodes.size() + 1];
        int[] M = new int[nodes.size() + 1];
        int[] first = new int[nodes.size() + 1];
        for (int i = 1; i < nodes.size() + 1; i++) {
            if (nodes.get(i - 1) == t) {
                M[i] = 0;
            } else {
                M[i] = Integer.MAX_VALUE / 2;
            }
            first[i] = -1;
            changedArray[i] = false;
        }
        changedArray[t.name] = true;
        boolean changed = true;
        while (changed) {
            changed = false;
            int[] Mnew = new int[nodes.size() + 1];
            for (int i = 1; i < nodes.size() + 1; i++) {
                Mnew[i] = M[i];
            }
            for (Node w : nodes) {
                if (changedArray[w.name]) {
                    for (Edge e : w.adjlistIn){
                        Node v = e.n1;
                        if (e.weight + M[w.name] < M[v.name]) {
                            Mnew[v.name] = e.weight + M[w.name];
                            first[v.name] = w.name;
                            changed = true;
                            changedArray[v.name] = true;
                        }
                    }
                }
            }
            for (int i = 1; i < nodes.size() + 1; i++) {
                M[i] = Mnew[i];
            }
        }
        Object [] returnArray = new Object[2];
        returnArray[0] = M;
        returnArray[1] = first;
        return returnArray;
    }// class Graph
}
